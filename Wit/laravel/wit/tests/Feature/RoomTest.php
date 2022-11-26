<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\RoomController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
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

        //はじめにルームを2個(ユーザIDを変えて)作成し、それぞれタグを１０個つける　、そのうち１つはパスワード付き        
        $this->rooms = Room::factory()->state(new Sequence(
            ['password' => null],
            ['password' => Hash::make(12345678)],
        ))->state(new Sequence(
            ['user_id' => $this->user->id],
            ['user_id' => $this->other_user->id],
        ))->count(2)->create();

        $this->room_id_1 = $this->rooms[0]->id;
        $this->room_id_2 = $this->rooms[1]->id;

        $this->tags = [];
        for ($tag_number = 1; $tag_number < 11; $tag_number++) {
            //name numberともに　１〜１０の値を付けて検索テストに使用する
            $tag = Tag::factory()->create(['name' => $tag_number, 'number' => $tag_number]);
            array_push($this->tags, $tag);
        }
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
        \Storage::disk('local')->assertExists('roomImages/RoomID:' . $room_id_2); //適切にルームイメージが保存されているか確認
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
        
        $this->post('logout'); //ユーザを変化させる場合はAuthenticatedSessionミドルウェアが働くので一旦ログアウトさせる
        //ルームにパスワードが付いている場合
        $this->actingAs($this->other_user);
        $response = $this->post('/home/saveRoom', [
            'room_id' => $this->room_id_2,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ルームにパスワードがついているため保存できません']);
        $this->post('logout'); //ユーザを変化させる場合はAuthenticatedSessionミドルウェアが働くので一旦ログアウトさせる

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
        $room = Room::find($this->room_id_1);

        ///入室していない状態でのチャットはCheckRoomIdではじかれる
        $message = Str::random(10);
        $response = $this->post('/home/room/chat/message', [
            'message' => $message,
            'room_id' => $this->room_id_1,
        ]);
        $response->assertStatus(422)->assertExactJson(['ルームIDの値が不正です']);

        //ルームにユーザを入室した状態に変更する
        $room->roomUsers()->syncWithoutDetaching($this->user->id);
        $room->roomUsers()->updateExistingPivot($this->user->id, ['in_room' => true]);

        //ルームIDの入力がないと422
        $response = $this->post('/home/room/chat/message', [
            'message' => $message,
            'room_id' => '',
        ]);
        $response->assertStatus(422)->assertExactJson(['ルームIDの値が不正です']);

        //ユーザが入室しているルームIDと送信してきたルームIDが異なる場合は422
        $response = $this->post('/home/room/chat/message', [
            'message' => $message,
            'room_id' => $this->room_id_2,
        ]);
        $response->assertStatus(422)->assertExactJson(['ルームIDの値が不正です']);

        //ユーザを２つ以上の部屋に入室したことにする
        Room::find($this->room_id_2)->roomUsers()->syncWithoutDetaching($this->user->id);
        Room::find($this->room_id_2)->roomUsers()->updateExistingPivot($this->user->id, ['in_room' => true]);

        //ルームIDがあっていても入室している部屋が2つ以上なので422
        $response = $this->post('/home/room/chat/message', [
            'message' => $message,
            'room_id' => $this->room_id_1,
        ]);
        $response->assertStatus(422)->assertExactJson(['ルームIDの値が不正です']);

        Room::find($this->room_id_2)->roomUsers()->updateExistingPivot($this->user->id, ['in_room' => false]);

        //room_idの入力ありだがメッセージの入力なし
        $response = $this->post('/home/room/chat/message', [
            'message' => '',
            'room_id' => $this->room_id_1,
        ]);
        $response->assertInvalid(['message']);

        //room_idもありメッセージの1000文字制限のバリデーションエラーチェック
        $response = $this->post('/home/room/chat/message', [
            'message' => Str::random(1001),
            'room_id' => $this->room_id_1,
        ]);
        $response->assertInvalid(['message']);

        //バリデーションエラーなし
        $message = Str::random(10);
        $response = $this->post('/home/room/chat/message', [
            'message' => $message,
            'room_id' => $this->room_id_1,
        ]);
        $response->assertOk()->assertExactJson(['Message Broadcast']);
        $this->assertDatabaseHas('room_chat', [
            'room_id' => $this->room_id_1,
            'user_id' => $this->user->id,
            'message' => $message,
        ]);

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
        $this->post('logout'); //ユーザを変化させる場合はAuthenticatedSessionミドルウェアが働くので一旦ログアウトさせる
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

        //Request headerにpusherの電子署名が付いていない時 そもそも全て404が返ってくる
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
        $response->assertNotFound();

        //pusherの電子署名をHeaderに付与する
        //nameがmember_removedの時　適切にステータスコード200ならOK
        $app_secret = env('PUSHER_APP_SECRET');
        $body = [
            'events' => [
                '0' =>
                [
                    'channel' => 'presence-room-user-notifications.' . $this->room_id_1,
                    'name' => 'member_removed',
                    'user_id' => $this->user->id,
                ]
            ]
        ];
        $webhook_signature = hash_hmac('sha256', is_string($body), $app_secret, false);
        $response = $this->withHeaders([
            'X-Pusher-Signature' => $webhook_signature,
        ])->post('/api/webhook', [
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

    //長くなるので２つに分ける
    public function test_search_room_id_and_tag()
    {
        $this->actingAs($this->user); //ユーザをログイン状態へ
        //id検索テスト checkの項目がtrueになることはなく常に１つのルームしか返さない　複数返すことはありえない　
        //keywordがない場合
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'id',
            'keyword' => '',
            'check_image' => 'false',
            'check_tag' => 'false',
            'check_password' => 'false',
            'check_post' => 'false',
        ]);
        $response->assertJsonCount(0);
        $response->assertJsonStructure([]);

        //id検索テスト 仮にcheckの値がtrueであっても参照しない
        //存在しないroomのidを入力した場合
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'id',
            'keyword' => Str::random(26),
            'check_image' => 'true',
            'check_tag' => 'true',
            'check_password' => 'true',
            'check_post' => 'true',
        ]);
        $response->assertJsonCount(0);
        $response->assertJsonStructure([]);

        //id検索テスト 仮にcheckの値がtrueであっても参照しない
        //存在するroomのidを入力した場合　適切にルームが１つ返ってくる
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'id',
            'keyword' => $this->room_id_1,
            'check_image' => 'true',
            'check_tag' => 'true',
            'check_password' => 'true',
            'check_post' => 'true',
        ]);
        $response->assertJsonCount(1);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'count_online_users',
                'count_chat_messages',
                'expired_time_left',
                'no_get_more',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
                'room_chat',
            ]
        ]);

        //tag検索テスト
        //keyword入力なしの場合
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'tag',
            'keyword' => '',
            'check_image' => 'true',
            'check_tag' => 'true',
            'check_password' => 'true',
            'check_post' => 'true',
        ]);
        $response->assertJsonCount(0);
        $response->assertJsonStructure([]);

        //tag検索テスト
        //存在しないtag_nameを入力した場合
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'tag',
            'keyword' => Str::random(26),
            'check_image' => 'true',
            'check_tag' => 'true',
            'check_password' => 'true',
            'check_post' => 'true',
        ]);
        $response->assertJsonCount(0);
        $response->assertJsonStructure([]);

        //tag検索テスト
        //存在するtag_nameを入力した場合　ここではtag_name'1'を例に適切にルームが返ってくることを確認 checkはすべてfalse
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'tag',
            'keyword' => '1',
            'check_image' => 'false',
            'check_tag' => 'false',
            'check_password' => 'false',
            'check_post' => 'false',
        ]);
        //パスワード付きの部屋とパスワードが付いていない部屋の２つ返ってくる
        $response->assertJsonCount(2);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'count_online_users',
                'count_chat_messages',
                'expired_time_left',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
                'room_chat',
            ]
        ]);

        //tag検索テスト
        //存在するtag_nameを入力した場合　ここではtag_name'1'を例に適切にルームが返ってくることを確認 check項目により検索結果が変わることを確認
        //check_tagがtrueになることはありえないが、ユーザのhtml等操作によりtrueになったとしても参照せずに適切に結果が返ってくることを確認
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'tag',
            'keyword' => '1',
            'check_image' => 'true',
            'check_tag' => 'true',
            'check_password' => 'true',
            'check_post' => 'false',
        ]);
        //check_passwordによりパスワード付きの部屋しか返ってこない
        $response->assertJsonCount(1);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'count_online_users',
                'count_chat_messages',
                'expired_time_left',
                'no_get_more',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
                'room_chat',
            ]
        ]);

        //tag検索テスト
        //存在するtag_nameを入力した場合　ここではtag_name'1'を例に適切にルームが返ってくることを確認 
        //tag_name = '1'がついているルームを1５個追加で作成し、Get_Moreの動作を確認
        $rooms = Room::factory()->count(15)->create();
        $tag_id = Tag::where('name', '1')->value('id');
        foreach ($rooms as $room) {
            $room->tags()->syncWithoutDetaching($tag_id);
        }
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'tag',
            'keyword' => '1',
            'room_id' => $rooms[0]->id,
            'check_image' => 'false',
            'check_tag' => 'false',
            'check_password' => 'false',
            'check_post' => 'false',
        ]);
        //新しく作成した１５個の部屋が最初返ってきており、Get_Moreにより2件しか返ってこないことを確認
        $response->assertJsonCount(2);
        $response->assertJsonStructure([
            '0' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'count_online_users',
                'count_chat_messages',
                'expired_time_left',
                //'no_get_more',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
                'room_chat',
            ],
            '1' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'count_online_users',
                'count_chat_messages',
                'expired_time_left',
                //'no_get_more',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
                'room_chat',
            ]
        ]);
    }

    public function test_search_room_keyword()
    {
        $this->actingAs($this->user); //ユーザをログイン状態に変更
        //ルームのバリエーションを増やしてcheck項目の検証に使う
        //roomを新たに３０件作成 keyword にwitという単語を用いる 検索する文字は小文字でも大文字でもどちらもマッチするようにしているので適切に小文字がサーチされるテストも兼ねる
        //setUp()で作成した部屋と合わせて合計３２件のルームが登録されている
        //長くなるので全てassertJsonStructure()を省略
        $rooms = Room::factory()->count(30)->create(['title' => 'apple', 'description' => 'Test Search Keyword Wit.']);

        //ルームイメージが付いている部屋を５つ作成
        for ($room_number = 0; $room_number < 5; $room_number++) {
            $room_image = new RoomImage;
            $room_controller = new RoomController;
            $room_image->room_id = $rooms[$room_number]->id;
            $uploaded_file = UploadedFile::fake()->image($room_number . '.jpg');
            $image_path = $room_controller->storeImage($uploaded_file, 0, $rooms[$room_number]->id);
            $room_image->image = $image_path;
            $room_image->save();
        }

        //tagが付いている部屋を10個作成
        for ($room_number = 5; $room_number < 15; $room_number++) {
            $tag_id = Tag::where('name', '1')->value('id');
            $rooms[$room_number]->tags()->syncWithoutDetaching($tag_id);
        }

        //passwordが付いている部屋を10個作成
        for ($room_number = 15; $room_number < 25; $room_number++) {
            $rooms[$room_number]->password = Hash::make(12345678);
            $rooms[$room_number]->save();
        }

        //post_roomを５つ作成
        for ($room_number = 25; $room_number < 30; $room_number++) {
            $rooms[$room_number]->posted_at = Carbon::now();
            $rooms[$room_number]->save();
        }

        //keyword検索テスト
        //keyword入力なしの場合　checkなしの場合
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'keyword',
            'keyword' => '',
            'check_image' => 'false',
            'check_tag' => 'false',
            'check_password' => 'false',
            'check_post' => 'false',
        ]);
        //idがいちばん新しいものから降順に15件取得されていることを確認
        $response->assertJsonCount(15);

        //keyword = wit, 　check_imageのみtrueの場合 
        //更にGet_Moreを組み合わせる
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'keyword',
            'keyword' => 'wit',
            'room_id' => $rooms[15]->id,
            'check_image' => 'true',
            'check_tag' => 'false',
            'check_password' => 'false',
            'check_post' => 'false',
        ]);
        //keyword = wit & check_imageに該当するのは25件だが画像がついていない部屋の１５番目をidとしてGet-Moreで取得するので10件返ってくる事を確認する
        $response->assertJsonCount(10);

        //keyword = wit, 　check_tagのみtrueの場合 
        //更にGet_Moreを組み合わせる
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'keyword',
            'keyword' => 'wit',
            'room_id' => $rooms[15]->id,
            'check_image' => 'false',
            'check_tag' => 'tag',
            'check_password' => 'false',
            'check_post' => 'false',
        ]);
        //keyword = wit & check_tagに該当するのは20件だがタグがついていない部屋の１５番目のidでGet_Moreを行うので5つ返ってくる事を確認
        $response->assertJsonCount(5);

        //keyword = APPLE, 　check_passwordのみtrueの場合 ここでkeywordをAPPLEに変更したのはtitleの文字列も検索結果にマッチすることをテストするため
        //鍵がついているかどうか確認するためにここだけassertJsonStructure()で確認する
        //更にGet_Moreを組み合わせる
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'keyword',
            'keyword' => 'APPLE',
            'check_image' => 'false',
            'check_tag' => 'false',
            'check_password' => 'true',
            'check_post' => 'false',
        ]);
        //keyword = APPLE & check_passwordに該当するのは10件なので10件返ってくることを確認
        $response->assertJsonCount(10);
        //パスワード付きのルームは必ずtype = 1となるので確認
        $response->assertJsonFragment(['type' => '1']);

        //keyword = APPLE, check_postのみtrueの場合
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'keyword',
            'keyword' => 'APPLE',
            'check_image' => 'false',
            'check_tag' => 'false',
            'check_password' => 'false',
            'check_post' => 'true',
        ]);
        //keyword = APPLE & check_postに該当するのは5件なので5件返ってくることを確認
        $response->assertJsonCount(5);


        //keyword検索テスト
        //keyword = APPLE, 　check_post,check_tag,check_passwordがtrueの場合
        //パスワード付きのルームとタグが登録されていないルームはpostルームとして保存されることはない
        //故にcheck_postとcheck_passwordまたはcheck_tagが同時にtrueになることはないが、もしなったとしたらcheck_postのみが適用されることを確認
        $response = $this->post('/home/searchRoom', [
            'search_type' => 'keyword',
            'keyword' => 'APPLE',
            'check_image' => 'false',
            'check_tag' => 'true',
            'check_password' => 'true',
            'check_post' => 'true',
        ]);
        //keyword = APPLE & check_postに該当するのは5件なので5件返ってくることを確認
        $response->assertJsonCount(5);
        //ルームイメージつきの部屋を５つ作成したからディレクトリの中身を必ず削除する
        for ($i = 0; $i < 5; $i++) {
            \Storage::disk('local')->deleteDirectory('roomImages/RoomID:' . $rooms[$i]->id);
        }
    }

    public function test_get_room_info()
    {
        $this->actingAs($this->user); //ユーザをログイン状態に変更
        //部屋を25個作成　setUP()で作成しているものと合わせて合計27個にしたい
        $rooms = Room::factory()->count(25)->create();
        //作成された降順に並んでいるか確認しやすいように10番目の部屋のtitleを10, 9番目の部屋のtitleを9に変更する
        $rooms[9]->title = '9';
        $rooms[10]->title = '10';
        $rooms[9]->save();
        $rooms[10]->save();
        //一つポストルームとして保存する
        $post_room = Room::find($this->room_id_1);
        $post_room->posted_at = Carbon::now();
        $post_room->save();

        //room_idを入力しない時適切にid降順にルームが１５個getできているか確認
        $response = $this->get('/getRoomInfo');
        $response->assertJsonCount(15);
        $response->assertJsonPath('14.title', '10');

        //room_idを入力時適切に送信したroom_id以降の10件が取得できているか確認
        $room_id = $rooms[10]->id;
        $response = $this->get('/getRoomInfo:' . $room_id);
        $response->assertJsonCount(10);
        $response->assertJsonPath('0.title', '9');

        //２７件のルームのうち２５件を取得したので残りの２件を取得したいが、一つはposted_atに値が入っているので1件しか取得されないことを確認
        $room_id = $rooms[0]->id;
        $response = $this->get('/getRoomInfo:' . $room_id);
        $response->assertJsonCount(1);
    }

    public function test_get_open_room()
    {
        $this->actingAs($this->user); //ユーザをログイン状態に変更
        //ルームの作成者を$this->userとして部屋を新たに３つ追加
        $rooms = Room::factory()->count(3)->create(['user_id' => $this->user->id]);
        //一つをポストルームとして保存
        $rooms[2]->posted_at = Carbon::now();
        $rooms[2]->save();

        //自分のopen roomを取得　post roomが省かれていることを確認
        $response = $this->get('/getOpenRoom');
        $response->assertJsonCount(3);
        $response->assertJsonPath('0.posted_at', null);
        $response->assertJsonPath('1.posted_at', null);
        $response->assertJsonPath('2.posted_at', null);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'count_online_users',
                'count_chat_messages',
                'expired_time_left',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
                'room_chat',
            ]
        ]);

        //他人のopen roomを取得　post roomが省かれていることを確認
        $this->post('logout'); //ユーザを変化させる場合はAuthenticatedSessionミドルウェアが働くので一旦ログアウトさせる
        $this->actingAs($this->other_user);
        $user_id = Crypt::encrypt($this->user->id);
        $response = $this->get('/getOpenRoom:' . $user_id);
        $response->assertJsonCount(3);
        $response->assertJsonPath('0.posted_at', null);
        $response->assertJsonPath('1.posted_at', null);
        $response->assertJsonPath('2.posted_at', null);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'count_online_users',
                'count_chat_messages',
                'expired_time_left',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
                'room_chat',
            ]
        ]);
    }

    public function test_get_post_room()
    {
        $this->actingAs($this->user); //ユーザをログイン状態に変更
        //ルームの作成者を$this->userとして部屋を新たに15個追加
        $rooms = Room::factory()->count(15)->create(['user_id' => $this->user->id]);
        //すべてポストルームとして保存
        foreach ($rooms as $room) {
            $room->posted_at = Carbon::now();
            $room->save();
        }

        //room_id user_id ともになし 10件取得確認
        $response = $this->get('/getPostRoom');
        $response->assertJsonCount(10);
        for ($room_number = 0; $room_number < 10; $room_number++) {
            $this->assertNotNull($response[$room_number]['posted_at']);
        }
        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
            ]
        ]);

        //room_id　あり user_id なし 5件取得確認
        $response = $this->get('/getPostRoom:' . $rooms[5]->id);
        $response->assertJsonCount(5);
        for ($room_number = 0; $room_number < 5; $room_number++) {
            $this->assertNotNull($response[$room_number]['posted_at']);
        }
        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
            ]
        ]);
        //room_id なし user_id　あり　つまり他人のpost_roomを初期で取得するルーティングは存在しない

        //room_id　あり user_id あり 他人のpost roomを取得する時　5件取得できることを確認
        $this->post('logout'); //ユーザを変化させる場合はAuthenticatedSessionミドルウェアが働くので一旦ログアウトさせる
        $this->actingAs($this->other_user);
        $user_id = Crypt::encrypt($this->user->id);
        $response = $this->get('/getPostRoom:' . $rooms[5]->id . '/' . $user_id);
        $response->assertJsonCount(5);
        for ($room_number = 0; $room_number < 5; $room_number++) {
            $res_user_id = Crypt::decrypt($response[$room_number]['user_id']);
            $this->assertSame($res_user_id, $this->user->id);
            $this->assertNotNull($response[$room_number]['posted_at']);
        }
        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
            ]
        ]);
    }

    public function test_get_list_room()
    {
        $this->actingAs($this->user); //ユーザをログイン状態に変更
        //ルームを15件(うち5件はpost roomに変更)新たに作成し、$this->userにリスト登録する
        $description = 'Auth User Listed';
        $post_rooms = Room::factory()->count(5)->create(['description' => $description, 'posted_at' => Carbon::now()]);
        $rooms = Room::factory()->count(10)->create(['description' => $description]);

        foreach ($post_rooms as $room) {
            $room->listRooms()->syncWithoutDetaching($this->user->id);
        }

        foreach ($rooms as $room) {
            $room->listRooms()->syncWithoutDetaching($this->user->id);
        }

        //room_id user_id 入力なし
        $response = $this->get('/getListRoom');
        $response->assertJsonCount(10);
        for ($room_number = 0; $room_number < 10; $room_number++) {
            $this->assertSame($response[$room_number]['description'], $description);
            //最初の取得する10件はpost roomでないことを確認する
            $this->assertNull($response[$room_number]['posted_at']);
        }

        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'count_online_users',
                'count_chat_messages',
                'expired_time_left',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
                'room_chat',
            ]
        ]);

        //room_id あり　user_id 入力なし　Get_More_List_Roomのテスト
        $response = $this->get('/getListRoom:' . $rooms[0]->id);
        $response->assertJsonCount(5);
        for ($room_number = 0; $room_number < 5; $room_number++) {
            $this->assertSame($response[$room_number]['description'], $description);
            //Get_Moreで取得する5件はpost roomであることを確認する
            $this->assertNotNull($response[$room_number]['posted_at']);
        }
        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
            ]
        ]);

        //room_id なし user_id　あり　つまり他人のlist_roomを初期で取得するルーティングは存在しない

        //room_id あり　 user_id 入力あり　Other_More_List_Roomのテスト
        $this->post('logout'); //ユーザを変化させる場合はAuthenticatedSessionミドルウェアが働くので一旦ログアウトさせる
        $this->actingAs($this->other_user);
        $user_id = Crypt::encrypt($this->user->id);
        $response = $this->get('/getListRoom:' . $rooms[0]->id . '/' . $user_id);
        $response->assertJsonCount(5);
        for ($room_number = 0; $room_number < 5; $room_number++) {
            $this->assertSame($response[$room_number]['description'], $description);
            //Get_Moreで取得する5件はpost roomであることを確認する
            $this->assertNotNull($response[$room_number]['posted_at']);
        }
        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
                'posted_at',
                'type',
                'user' => [
                    'id',
                    'name',
                    'profile_image',
                ],
                'tags' => [
                    '*' => [
                        'name',
                        'number',
                        'pivot' => [
                            'room_id',
                            'tag_id',
                        ],
                    ],
                ],
            ]
        ]);
    }

    public function test_action_add_list_room()
    {
        $this->actingAs($this->user); //ユーザをログイン状態へ
        //room_id入力なし
        $response = $this->get('/home/addListRoom:');
        $response->assertNotFound();

        //存在しないroom_idを入力した時
        $str_room_id = Str::random(26);
        $response = $this->get('/home/addListRoom:' . $str_room_id);
        $response->assertJsonPath('error_message', 'ルーム:' . $str_room_id . 'は存在しません');

        //すでにリストに登録されている部屋をリストに追加しようとした時
        $room = Room::find($this->room_id_2);
        $room->listRooms()->syncWithoutDetaching($this->user->id);
        $response = $this->get('/home/addListRoom:' . $room->id);
        $response->assertJsonPath('error_message', 'このルームは既にリストに追加されています');

        //適切にリストに登録される時
        $response = $this->get('/home/addListRoom:' . $this->room_id_1);
        $response->assertJsonPath('message', 'リストにルームを追加しました');
    }

    public function test_action_remove_list_room()
    {
        $this->actingAs($this->user); //ユーザをログイン状態へ
        //room_id入力なし
        $response = $this->get('/home/removeListRoom:');
        $response->assertNotFound();

        //存在しないroom_idを入力した時
        $str_room_id = Str::random(26);
        $response = $this->get('/home/removeListRoom:' . $str_room_id);
        $response->assertJsonPath('error_message', 'ルーム:' . $str_room_id . 'は存在しません');

        //リストに登録していないroom_idを入力した時
        $response = $this->get('/home/removeListRoom:' . $this->room_id_1);
        $response->assertJsonPath('error_message', 'このルームはリストに登録されていません');

        //すでにリストに登録されている部屋をリストに追加しようとした時
        $room = Room::find($this->room_id_2);
        $room->listRooms()->syncWithoutDetaching($this->user->id);
        $response = $this->get('/home/removeListRoom:' . $room->id);
        $response->assertJsonPath('message', 'リストからルームを削除しました');
    }

    public function test_receive_file()
    {
        $this->actingAs($this->user); //ユーザをログイン状態へ
        $room = Room::find($this->room_id_1);

        //部屋に入場する前にroom_idを送ってもはじかれる
        $response = $this->post('/home/room/chat/file', [
            'room_id' => $this->room_id_1,
            'file' => '',
        ]);
        $response->assertStatus(422)->assertExactJson(['ルームIDの値が不正です']);

        //ユーザを部屋に入室したことにする
        $room->roomUsers()->syncWithoutDetaching($this->user->id);
        $room->roomUsers()->updateExistingPivot($this->user->id, ['in_room' => true]);

        //room_idの値がなかったらはじかれる
        $response = $this->post('/home/room/chat/file', [
            'room_id' => '',
            'file' => '',
        ]);
        $response->assertStatus(422)->assertExactJson(['ルームIDの値が不正です']);

        //ユーザが入室している部屋が２つ以上だった場合(in_room = trueの値が２つ以上存在　理論的にはありえない)
        Room::find($this->room_id_2)->roomUsers()->syncWithoutDetaching($this->user->id);
        Room::find($this->room_id_2)->roomUsers()->updateExistingPivot($this->user->id, ['in_room' => true]);

        $response = $this->post('/home/room/chat/file', [
            'room_id' => $this->room_id_1,
            'file' => '',
        ]);
        $response->assertStatus(422)->assertExactJson(['ルームIDの値が不正です']);

        //ユーザが入室している部屋を一つにする(room_id_1のほう)
        Room::find($this->room_id_2)->roomUsers()->updateExistingPivot($this->user->id, ['in_room' => false]);

        //ミドルウェア CheckRoomIdは通るが、UploadFileRequestのバリデーションエラーが発生 file required
        $response = $this->post('/home/room/chat/file', [
            'room_id' => $this->room_id_1,
            'file' => '',
        ]);
        $response->assertInvalid(['file']);

        //file バリデーション fileがfile形式じゃないとき
        $response = $this->post('/home/room/chat/file', [
            'room_id' => $this->room_id_1,
            'file' => 'string',
        ]);
        $response->assertInvalid(['file']);

        //file バリデーション fileの拡張子が認められていないもののとき
        $response = $this->post('/home/room/chat/file', [
            'room_id' => $this->room_id_1,
            'file' => UploadedFile::fake()->image('test.doc'),
        ]);
        $response->assertInvalid(['file']);

        //バリデーションエラーなしのとき
        $response = $this->post('/home/room/chat/file', [
            'room_id' => $this->room_id_1,
            'file' => UploadedFile::fake()->image('test.jpeg'),
        ]);
        $response->assertOK()->assertExactJson(['File Send Success']);
        $this->assertDatabaseHas('room_chat', [
            'room_id' => $this->room_id_1,
            'user_id' => $this->user->id,
            'postfile' => 'test.jpeg',
        ]);

        //必ず最後は削除す
        \Storage::disk('local')->deleteDirectory('roomFiles/RoomID:' . $this->room_id_1); 
    }

    public function test_store_file()
    {
        $this->actingAs($this->user); //ユーザをログイン状態へ
        $room_id = $this->room_id_1;
        $room_controller = new RoomController;
        $upload_file = UploadedFile::fake()->image('test.jpg');
        $file_name = 'test.jpg';

        //Fileを保存
        $room_controller->storeFile($upload_file, $room_id);
        \Storage::disk('local')->assertExists('roomFiles/RoomID:' . $room_id . '/' . $file_name);

        //２回め移行同じ名前のファイルがすでに保存されているとファイル名に(1),(2)などをつけているか確認
        $room_controller->storeFile($upload_file, $room_id);
        \Storage::disk('local')->assertExists('roomFiles/RoomID:' . $room_id . '/' . 'test(1).jpg');

        $room_controller->storeFile($upload_file, $room_id);
        \Storage::disk('local')->assertExists('roomFiles/RoomID:' . $room_id . '/' . 'test(2).jpg');

        //必ず最後は削除す
        \Storage::disk('local')->deleteDirectory('roomFiles/RoomID:' . $room_id); 
    }

    public function test_receive_choice_messages()
    {
        $this->actingAs($this->user); //ユーザをログイン状態へ
        $room = Room::find($this->room_id_1);

        //部屋に入場する前にroom_idを送ってもはじかれる
        $response = $this->post('/home/room/chat/choice', [
            'room_id' => $this->room_id_1,
            'target_array' => '',
        ]);
        $response->assertStatus(422)->assertExactJson(['ルームIDの値が不正です']);

        //ユーザを部屋に入室したことにする
        $room->roomUsers()->syncWithoutDetaching($this->user->id);
        $room->roomUsers()->updateExistingPivot($this->user->id, ['in_room' => true]);

        //room_idの値がなかったらはじかれる
        $response = $this->post('/home/room/chat/choice', [
            'room_id' => '',
            'target_array' => '',
        ]);
        $response->assertStatus(422)->assertExactJson(['ルームIDの値が不正です']);

        //ユーザが入室している部屋が２つ以上だった場合(in_room = trueの値が２つ以上存在　理論的にはありえない)
        Room::find($this->room_id_2)->roomUsers()->syncWithoutDetaching($this->user->id);
        Room::find($this->room_id_2)->roomUsers()->updateExistingPivot($this->user->id, ['in_room' => true]);

        $response = $this->post('/home/room/chat/choice', [
            'room_id' => $this->room_id_1,
            'target_array' => '',
        ]);
        $response->assertStatus(422)->assertExactJson(['ルームIDの値が不正です']);

        //ユーザが入室している部屋を一つにする(room_id_1のほう)
        Room::find($this->room_id_2)->roomUsers()->updateExistingPivot($this->user->id, ['in_room' => false]);

        // target_array required バリデーションエラー
        $response = $this->post('/home/room/chat/choice', [
            'room_id' => $this->room_id_1,
            'target_array' => '',
        ]);
        $response->assertInvalid(['target_array']);

        // target_array array バリデーションエラー
        $response = $this->post('/home/room/chat/choice', [
            'room_id' => $this->room_id_1,
            'target_array' => 'string',
        ]);
        $response->assertInvalid(['target_array']);

        $room->roomChat()->attach($this->user, ['message' => 'Choice Check用テストメッセージ1']);
        $chat_id_1 = $this->user->roomChat->sortBy('id')->last()->pivot->id;
        $chat_choice_1 = $room->roomChat()->where('room_chat.message','Choice Check用テストメッセージ1')->first()->pivot->choice;
        $room->roomChat()->attach($this->user, ['message' => 'Choice Check用テストメッセージ2']);
        $chat_id_2 = $room->roomChat()->where('room_chat.message','Choice Check用テストメッセージ2')->first()->pivot->id;
        $chat_choice_2 = $room->roomChat()->where('room_chat.message','Choice Check用テストメッセージ2')->first()->pivot->choice;
        $this->assertFalse($chat_choice_1);
        $this->assertFalse($chat_choice_2);

        // バリデーションなし choice がfalse→true に変わればOK
        $response = $this->post('/home/room/chat/choice', [
            'room_id' => $this->room_id_1,
            'target_array' => [$chat_id_1,$chat_id_2],
        ]);
        $response->assertOK()->assertExactJson(['Message Choiced']);

        $chat_choice_1_after = $room->roomChat()->where('room_chat.message','Choice Check用テストメッセージ1')->first()->pivot->choice;
        $chat_choice_2_after = $room->roomChat()->where('room_chat.message','Choice Check用テストメッセージ2')->first()->pivot->choice;
        $this->assertTrue($chat_choice_1_after);
        $this->assertTrue($chat_choice_2_after);

        // バリデーションなし　choice がtrue→false に変わればOK
        $response = $this->post('/home/room/chat/choice', [
            'room_id' => $this->room_id_1,
            'target_array' => [$chat_id_1,$chat_id_2],
        ]);
        $response->assertOK()->assertExactJson(['Message Choiced']);

        $chat_choice_1_after = $room->roomChat()->where('room_chat.message','Choice Check用テストメッセージ1')->first()->pivot->choice;
        $chat_choice_2_after = $room->roomChat()->where('room_chat.message','Choice Check用テストメッセージ2')->first()->pivot->choice;
        $this->assertFalse($chat_choice_1_after);
        $this->assertFalse($chat_choice_2_after);
    }
}
