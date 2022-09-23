<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\RoomController;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use function PHPUnit\Framework\assertFalse;

class RoomTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    protected $user;
    protected $other_user;
    protected $rooms;
    protected $room_id_1;
    protected $room_id_2;
    protected $tags;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'Auth',
        ]);

        $this->other_user = User::factory()->create([
            'name' => 'Other',
        ]);

        //はじめにルームを2個(ユーザIDを変えて)作成し、それぞれタグを１０個つける　、パスワード付きも半分作成する
        $this->rooms = Room::factory()->state(new Sequence(
            ['password' => null],
            ['password' => Hash::make(12345678)],
        ))->state(new Sequence(
            ['user_id' => $this->user->id],
            ['user_id' => $this->other_user->id],
        ))->count(2)->create();

        $this->room_id_1 = $this->rooms[0]->id;
        $this->room_id_2 = $this->rooms[1]->id;

        $this->tags = Tag::factory()->count(10)->create();
        foreach ($this->rooms as $room) {
            foreach ($this->tags as $tag) {
                $room->tags()->syncWithoutDetaching($tag->id);
            }
        }
    }


    public function test_create_room()
    {
        $room_images = [];
        $this->actingAs($this->user);  //userをログイン状態にする
        //すでにこのユーザで部屋を１つ作成済なので２つしか追加作成できない

        //正常に部屋が作成される時　１つ目　パスワードなし
        for ($i = 0; $i < 30; $i++) { //画像を30枚適当に生成している
            array_push($room_images, UploadedFile::fake()->image($i . '.jpg'));
        }
        $response = $this->post('/home/createRoom', [
            'title' => 'TestRoom',
            'description' => 'Create Room Test',
            'tag' => 'hoge;fuga;bar;foo;',
            'room_images' => $room_images,
        ]);
        $room_id = Room::where('title', 'TestRoom')->value('id');
        $response->assertStatus(302)->assertRedirect('/home/room:' . $room_id);
        \Storage::disk('local')->assertExists('roomImages/RoomID:' . $room_id); //適切にルームイメーじが保存されているか確認
        \Storage::disk('local')->deleteDirectory('roomImages/RoomID:' . $room_id); //必ず最後は削除する

        //正常に部屋が作成される時　２つ目　パスワードあり　適切にセッションがセットされているか確認
        $response = $this->post('/home/createRoom', [
            'title' => 'TestRoom2',
            'description' => 'Create Room Test',
            'tag' => 'hoge;fuga;bar;foo;',
            'create_password' => 12345678,
            'create_password_confirmation' => 12345678,
            'room_images' => $room_images,
        ]);
        $room_id_2 = Room::where('title', 'TestRoom2')->value('id');
        $response->assertSessionHasNoErrors();
        $response->assertValid(['title', 'description', 'create_password', 'sum_image_count', 'sum_image_size']);
        $response->assertSessionHas(['auth_room_id' => $room_id_2])->assertStatus(302)->assertRedirect('/home/room:' . $room_id_2);
        \Storage::disk('local')->assertExists('roomImages/RoomID:' . $room_id_2); //適切にルームイメーじが保存されているか確認
        \Storage::disk('local')->deleteDirectory('roomImages/RoomID:' . $room_id_2); //必ず最後は削除する

        //同じユーザで部屋を4つ目を作成しようとした時の動作　３つ以上は同時に開設できないからエラーセッションが送られるはず
        $response = $this->post('/home/createRoom', [
            'title' => 'TestRoom3',
            'description' => 'Create Room Test',
            'tag' => 'hoge;fuga;bar;foo;',
            'create_password' => 12345678,
            'create_password_confirmation' => 12345678,
            'room_images' => $room_images,
        ]);
        $response->assertValid(['title', 'description', 'create_password', 'sum_image_count', 'sum_image_size']);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => '同時に開設できるルームは３つまでです。ルームを保存するか削除して下さい']);


        //バリデーションが引っかかるケース
        for ($i = 0; $i < 5; $i++) { //前のと合わせて画像が35枚なので３０枚より多く引っかかる
            array_push($room_images, UploadedFile::fake()->image($i . '.jpg'));
        }
        $response = $this->post('/home/createRoom', [
            'title' => '',
            'description' => '',
            'tag' => 'hogehogehogehogehogehoge;', //24文字なので引っかかる
            'room_images' => $room_images,
            'create_password' => 12345,
            'create_password_confirmation' => 12345678,
        ]);
        $response->assertInvalid(['sum_image_count', 'matches.0', 'title', 'description', 'create_password']);
    }

    public function test_remove_room()
    {
        $this->actingAs($this->user); //ユーザをログイン状態にする

        //ルームIDがリクエスト内に存在しない時
        $response = $this->post('/home/removeRoom', [
            'hoge' => 'hogehoge',
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが発生しました']);
        //ルームIDが存在しないルームの時
        $str_room_id = Str::random(26);
        $response = $this->post('/home/removeRoom', [
            'room_id' => $str_room_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ルーム:' . $str_room_id . 'は存在しません']);

        //ログインユーザとルームの作成者が一致しない場合
        $response = $this->post('/home/removeRoom', [
            'room_id' => $this->room_id_2,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ログインユーザーとルームの作成者が一致しません']);

        //ルームが適切に削除される時 
        $tag_1 = Tag::factory()->create(['number' => 2]);
        $tag_2 = Tag::factory()->create(['number' => 1]);
        $tag_id_1 = $tag_1->id;
        $tag_id_2 = $tag_2->id;
        $tag_number = $tag_1->number;
        $this->rooms[0]->tags()->syncWithoutDetaching([$tag_id_1, $tag_id_2]);
        $response = $this->post('/home/removeRoom', [
            'room_id' => $this->room_id_1,
        ]);
        $this->assertDeleted($this->rooms[0]);
        //dd(Tag::find($tag_id_1)->number,$tag_number);
        $this->assertSame($tag_number - 1, Tag::find($tag_id_1)->number); //タグナンバーが２だったものは-1され１になる
        $this->assertDeleted($tag_2); //タグナンバーが１だったものを０になりテーブルから削除される
        \Storage::disk('local')->assertMissing('/roomImages/RoomID:' . $this->room_id_1);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['action_message' => 'ルーム:' . $this->room_id_1 . 'が削除されました']);
    }

    public function test_save_room()
    {
        $this->actingAs($this->user);  //userをログイン状態にする

        //ルームIDがリクエスト内に存在しない時
        $response = $this->post('/home/saveRoom', [
            'hoge' => 'hogehoge',
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが発生しました']);

        //存在しないルームIDの時
        $str_room_id = Str::random(26);
        $response = $this->post('/home/saveRoom', [
            'room_id' => $str_room_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ルーム:' . $str_room_id . 'は存在しません']);

        //ログインユーザとルームの作成者が一致しない場合
        $response = $this->post('/home/saveRoom', [
            'room_id' => $this->room_id_2,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ログインユーザーとルームの作成者が一致しません']);

        //ルームにパスワードが付いている場合
        $this->actingAs($this->other_user);
        $response = $this->post('/home/saveRoom', [
            'room_id' => $this->room_id_2,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ルームにパスワードがついているため保存できません']);

        //ルームにタグが付いていない場合
        $this->actingAs($this->user);
        $room = Room::factory()->create(['user_id' => $this->user->id]);
        $room_id = $room->id;
        $response = $this->post('/home/saveRoom', [
            'room_id' => $room_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ルームにタグが付いていないため保存できません']);

        //適切にルームがPOSTルームとして保存される時
        Room::find($this->room_id_1)->roomBans()->syncWithoutDetaching($this->other_user->id);
        Room::find($this->room_id_1)->roomUsers()->syncWithoutDetaching($this->other_user->id);
        $this->assertDatabaseHas('room_bans', [
            'room_id' => $this->room_id_1,
            'user_id' => $this->other_user->id,
        ]);

        $response = $this->post('/home/saveRoom', [
            'room_id' => $this->room_id_1,
        ]);

        $this->assertDatabaseMissing('room_bans', [
            'room_id' => $this->room_id_1,
            'user_id' => $this->other_user->id,
        ]);

        $this->assertDatabaseHas('room_users', [
            'room_id' => $this->room_id_1,
            'user_id' => $this->other_user->id,
        ]);

        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['action_message' => 'ルーム:' . $this->room_id_1 . 'の保存が完了しました']);
        $this->assertNotNull(Room::find($this->room_id_1)->posted_at);
    }


    public function test_store_image()
    {
        $room_controller = new RoomController;
        $room_id = $this->room_id_1;
        $this->actingAs($this->user);  //userをログイン状態にする
        $upload_file = UploadedFile::fake()->image('fuga.jpg');
        //imgがnullの時
        $response = $room_controller->storeImage(null, 0, $room_id);
        $this->assertNull($response);

        //image_countが0の時
        $response = $room_controller->storeImage($upload_file, null, $room_id);
        $this->assertNull($response);

        //room_idがNULLの時
        $response = $room_controller->storeImage($upload_file, 0, null);
        $this->assertNull($response);

        //適切に画像が保存される時
        $image_count = rand(0, 10);
        $extension = $upload_file->getClientOriginalExtension();
        $response = $room_controller->storeImage($upload_file, rand(0, 10), $room_id);
        \Storage::disk('local')->assertExists($response);
        \Storage::disk('local')->deleteDirectory('roomImages/RoomID:' . $room_id, 'no' . $image_count . '.' . $extension); //必ず最後は削除する
    }

    public function test_show_room_image()
    {
        $this->actingAs($this->user);  //userをログイン状態にする
        $room_controller = new RoomController;
        $upload_file_1 = UploadedFile::fake()->image('hoge.png');
        $upload_file_2 = UploadedFile::fake()->image('fuga.png');
        //パスワードなしとありの部屋２つそれぞれに３つずつルームイメージを紐付ける
        for ($i = 0; $i < 3; $i++) {
            $room_image_1 = new RoomImage;
            $room_image_2 = new RoomImage;
            $room_image_1->room_id = $this->room_id_1;
            $room_image_2->room_id = $this->room_id_2;
            $room_image_1->image = $room_controller->storeImage($upload_file_1, $i, $this->room_id_1);
            $room_image_2->image = $room_controller->storeImage($upload_file_2, $i, $this->room_id_2);
            $room_image_1->save();
            $room_image_2->save();

            //存在しない画像を参照する
            $response = $this->get('/home/room:' . $this->room_id_1 . '/showRoomImage:4');
            $response2 = $this->get('/home/room:' . $this->room_id_2 . '/showRoomImage:4');
            $response->assertStatus(404);
            $response2->assertStatus(404);

            //存在する画像を参照する
            $response = $this->get('/home/room:' . $this->room_id_1 . '/showRoomImage:' . $i);
            $response2 = $this->get('/home/room:' . $this->room_id_2 . '/showRoomImage:' . $i);
            $response2->assertStatus(404); //パスワード付きルームの画像はセッションをセットしないと閲覧できない
            $response->assertOk();

            session()->put('auth_room_id', $this->room_id_2); //セッションをセットしもう一度パスワード付きのルーム画像を取得する
            $response2 = $this->get('/home/room:' . $this->room_id_2 . '/showRoomImage:' . $i);
            $response2->assertOk(); //今度はステータスコード２００が適切に返ってくる
            session()->forget('auth_room_id', $this->room_id_2);
        }

        \Storage::disk('local')->deleteDirectory('roomImages/RoomID:' . $this->room_id_1); //必ず最後は削除する
        \Storage::disk('local')->deleteDirectory('roomImages/RoomID:' . $this->room_id_2); //必ず最後は削除する
    }

    public function test_receive_message()
    {
        $this->actingAs($this->user);  //userをログイン状態にする
        //バリデーションエラーなし
        $message = Str::random(10);
        $response = $this->post('/home/room/chat/message', [
            'message' => $message,
            'room_id' => $this->room_id_1,
        ]);
        $response->assertOk();
        $this->assertDatabaseHas('room_chat', [
            'room_id' => $this->room_id_1,
            'user_id' => $this->user->id,
            'message' => $message,
        ]);

        //room_id の入力なし
        $response = $this->post('/home/room/chat/message', [
            'message' => '',
            'room_id' => '',
        ]);
        $response->assertStatus(404);

        //room_idの入力ありだがメッセージの入力なし
        $response = $this->post('/home/room/chat/message', [
            'message' => '',
            'room_id' => $this->room_id_1,
        ]);
        $response->assertInvalid(['message']);

        //room_idもありメッセージの10００文字制限のバリデーションエラーチェック
        $response = $this->post('/home/room/chat/message', [
            'message' => Str::random(1001),
            'room_id' => $this->room_id_1,
        ]);
        $response->assertInvalid(['message']);

        //チャットカウントが１０００を超えたときのバリデーション
        $room = Room::find($this->room_id_1);
        for ($i = 0; $i < 1000; $i++) {
            $room->roomChat()->attach($this->user, ['message' => Str::random(10)]);
        }

        $response = $this->post('/home/room/chat/message', [
            'message' => Str::random(10),
            'room_id' => $this->room_id_1,
        ]);
        $response->assertInvalid(['chat_count']);
    }

    public function test_receive_ban_user()
    {
        $room_id = $this->room_id_2;
        $user_id = $this->other_user->id;
        $this->actingAs($this->user); //ユーザをログイン状態へ

        //room_id 入力なしのとき
        $response = $this->post('/home/room/ban/', [
            'user_id' => $user_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが発生しました']);

        //room_idが存在しない部屋のとき
        $response = $this->post('/home/room/ban/', [
            'user_id' => $user_id,
            'room_id' => Str::random(26),
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが発生しました']);

        //user_idが存在しないユーザのとき
        $response = $this->post('/home/room/ban/', [
            'user_id' => Str::random(26),
            'room_id' => $room_id
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:' . $room_id);

        //user_id が部屋の管理者のとき
        $response = $this->post('/home/room/ban/', [
            'user_id' => $user_id,
            'room_id' => $room_id,
        ]);
        $this->assertDatabaseMissing('room_bans', [
            'room_id' => $room_id,
            'user_id' => $user_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:' . $room_id);

        //部屋の管理者以外のユーザがリクエストを送ってきた時
        $user_id = $this->user->id;
        $response = $this->post('/home/room/ban/', [
            'user_id' => $user_id,
            'room_id' => $room_id,
        ]);
        $this->assertDatabaseMissing('room_bans', [
            'room_id' => $room_id,
            'user_id' => $user_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:' . $room_id);

        //適切にバンされる時
        $user_id = $this->other_user->id;
        $room_id = $this->room_id_1;
        Room::find($room_id)->roomUsers()->syncWithoutDetaching($user_id);
        $response = $this->post('/home/room/ban/', [
            'user_id' => $user_id,
            'room_id' => $room_id,
        ]);
        $this->assertDatabaseHas('room_bans', [
            'room_id' => $room_id,
            'user_id' => $user_id,
        ]);
        $this->assertDatabaseMissing('room_users', [
            'room_id' => $room_id,
            'user_id' => $user_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:' . $room_id);
    }

    public function test_receive_lift_ban_user()
    {
        $room_id = $this->room_id_2;
        $user_id = $this->other_user->id;
        $this->actingAs($this->user); //ユーザをログイン状態へ

        //room_id 入力なしのとき
        $response = $this->post('/home/room/ban/lift', [
            'user_id' => $user_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが発生しました']);

        //room_idが存在しない部屋のとき
        $response = $this->post('/home/room/ban/lift', [
            'user_id' => $user_id,
            'room_id' => Str::random(26),
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが発生しました']);

        //user_idが存在しないユーザのとき
        $response = $this->post('/home/room/ban/lift', [
            'user_id' => Str::random(26),
            'room_id' => $room_id
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:' . $room_id);

        //user_id が部屋の管理者のとき
        $response = $this->post('/home/room/ban/lift', [
            'user_id' => $user_id,
            'room_id' => $room_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:' . $room_id);

        //部屋の管理者以外のユーザがリクエストを送ってきた時
        $user_id = $this->user->id;
        $response = $this->post('/home/room/ban/', [
            'user_id' => $user_id,
            'room_id' => $room_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:' . $room_id);

        //適切にリフトバンされる時
        $user_id = $this->other_user->id;
        $room_id = $this->room_id_1;
        Room::find($room_id)->roomBans()->syncWithoutDetaching($user_id);
        $this->assertDatabaseHas('room_bans', [
            'room_id' => $room_id,
            'user_id' => $user_id,
        ]);

        $response = $this->post('/home/room/ban/lift', [
            'user_id' => $user_id,
            'room_id' => $room_id,
        ]);

        $this->assertDatabaseMissing('room_bans', [
            'room_id' => $room_id,
            'user_id' => $user_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:' . $room_id);
    }

    public function test_enter_room()
    {
        $this->actingAs($this->user); //ユーザをログイン状態へ

        $str_room_id = Str::random(26);
        //存在しないルームのルームID
        $response = $this->get('/home/room:' . $str_room_id);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ルーム:' . $str_room_id . 'は存在しません']);

        //posted_atに値が入っている場合
        $room = Room::factory()->create(['posted_at' => Carbon::now()]);
        $response = $this->get('/home/room:' . $room->id);
        $response->assertStatus(302)->assertRedirect('/home/postRoom:' . $room->id);

        //room_bansに登録されているユーザが入室しようとした時
        $room = Room::factory()->create(['user_id' => $this->other_user->id]);
        $room->roomBans()->syncWithoutDetaching($this->user->id);
        $response = $this->get('/home/room:' . $room->id);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ルーム:' . $room->id . 'へのアクセスが禁止されています']);
        $room->roomBans()->detach($this->user->id);

        //ルームに１０人入ってる状態で管理者ではないユーザが入室しようとした時
        for ($user_number = 0; $user_number < 10; $user_number++) {
            $user = User::factory()->create();
            $room->roomUsers()->syncWithoutDetaching($user->id);
            $room->roomUsers()->updateExistingPivot($user->id, ['in_room' => true]);
        }
        $response = $this->get('/home/room:' . $room->id);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ルームの最大人数(作成者を除いて10人まで)を超過したため入室できません']);

        //ルームに10人入っている状態で管理者ユーザが入室しようとした時
        $this->actingAs($this->other_user);
        $response = $this->get('/home/room:' . $room->id);
        $response->assertStatus(200)->assertViewIs('wit.room');
        $response->assertViewHasAll([ //responseに以下のデータが存在しているか
            'room_info',
            'count_image_data',
            'auth_user',
            'expired_time_left',
        ]);

        //ルームにパスワードが付いており、セッションがセットされていない時
        $response = $this->get('/home/room:' . $this->room_id_2);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'パスワード付きのルームです']);

        //ルームにパスワードが付いており、セッションがセットされている時
        session()->put('auth_room_id', $this->room_id_2);
        $response = $this->get('/home/room:' . $this->room_id_2);
        $response->assertStatus(200)->assertViewIs('wit.room');
        $response->assertViewHasAll([ //responseに以下のデータが存在しているか
            'room_info',
            'count_image_data',
            'auth_user',
            'expired_time_left',
        ]);

        //パスワードがついていない部屋に普通に入室する時
        $response = $this->get('/home/room:' . $this->room_id_1);
        $response->assertStatus(200)->assertViewIs('wit.room');
        $response->assertViewHasAll([ //responseに以下のデータが存在しているか
            'room_info',
            'count_image_data',
            'auth_user',
            'expired_time_left',
        ]);
    }

    public function test_auth_room_password()
    {
        $this->actingAs($this->user); //ユーザをログイン状態へ

        //ルームIDがリクエストに存在しない時
        $response = $this->post('/home/authRoomPassword', [
            'hogehoge' => 'hogehoge',
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが発生しました']);

        //enter_passwordが入力されておらず、存在するルームのルームIDをリクエストに含めた時
        $response = $this->post('/home/authRoomPassword', [
            'room_id' => $this->room_id_2,
        ]);
        $response->assertInvalid(['enter_password']);

        $str_room_id = Str::random(26);

        //enter_passwordが正しく、存在しないルームのルームIDをリクエストに含めた時
        $response = $this->post('/home/authRoomPassword', [
            'enter_password' => 12345678,
            'room_id' => $str_room_id,
        ]);
        $response->assertInvalid(['enter_password']);

        //enter_passwordが正しくなく、存在するルームのルームIDをリクエスト煮含めた時
        $response = $this->post('/home/authRoomPassword', [
            'enter_password' => 123456789,
            'room_id' => $this->room_id_2,
        ]);
        $response->assertInvalid(['enter_password']);

        //enter_password,room_idともに正しいが、部屋にパスワードが付いていない時
        $response = $this->post('/home/authRoomPassword', [
            'enter_password' => 12345678,
            'room_id' => $this->room_id_1,
        ]);
        $response->assertInvalid(['enter_password']);

        //enter_password,room_idともに正しく、部屋にパスワードが付いている時
        $response = $this->post('/home/authRoomPassword', [
            'enter_password' => 12345678,
            'room_id' => $this->room_id_2,
        ]);
        $response->assertSessionHas(['auth_room_id' => $this->room_id_2]);
        $response->assertStatus(302)->assertRedirect('/home/room:' . $this->room_id_2);
    }

    public function test_show_post_room()
    {
        $this->actingAs($this->user); //ユーザをログイン状態へ

        $str_room_id = Str::random(26);
        //存在しないルームのルームID
        $response = $this->get('/home/postRoom:' . $str_room_id);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ルーム:' . $str_room_id . 'は存在しません']);

        //posted_atに値が入っていない場合
        $response = $this->get('/home/postRoom:' . $this->room_id_1);
        $response->assertStatus(302)->assertRedirect('/home/room:' . $this->room_id_1);

        //適切にPostRoomに入室できる時
        $room = Room::factory()->create(['posted_at' => Carbon::now()]);
        $response = $this->get('/home/postRoom:' . $room->id);
        $response->assertStatus(200)->assertViewIs('wit.post_room');
        $response->assertViewHasAll([ //responseに以下のデータが存在しているか
            'room_info',
            'count_image_data',
            'auth_user',
        ]);
    }

    public function test_receive_webhook() //外部APIに依存している唯一のアクション
    {
        $room = Room::find($this->room_id_1);
        $room->roomUsers()->syncWithoutDetaching($this->user->id);
        $room->roomUsers()->updateExistingPivot($this->user->id, ['in_room' => true]);

        //存在しないリクエストを送った時
        $response = $this->post('/api/webhook', [
            'events' => [
                '0' =>
                [
                    'channel' => 'presence-room-user-notifications.adsfadfdsaf',
                    'name' => 'asdfassaf',
                    'user_id' => 'hogehogehogehoge',
                ]
            ]
        ]);
        $response->assertNotFound();

        //nameがmember_addedの時　適切にステータスコード200ならOK
        $response = $this->post('/api/webhook', [
            'events' => [
                '0' =>
                [
                    'channel' => 'presence-room-user-notifications.' . $this->room_id_1,
                    'name' => 'member_added',
                    'user_id' => $this->user->id,
                ]
            ]
        ]);
        $response->assertOk();

        //nameがmember_removedの時　適切にステータスコード200ならOK
        $response = $this->post('/api/webhook', [
            'events' => [
                '0' =>
                [
                    'channel' => 'presence-room-user-notifications.' . $this->room_id_1,
                    'name' => 'member_removed',
                    'user_id' => $this->user->id,
                ]
            ]
        ]);
        $response->assertOk();

        
        //webhookにより適切にルームユーザが退室していることになっているか確認
        $this->assertFalse($room->roomUsers[0]->pivot->in_room);
        $this->assertNotNull($room->roomUsers[0]->pivot->exited_at);
    }
}
