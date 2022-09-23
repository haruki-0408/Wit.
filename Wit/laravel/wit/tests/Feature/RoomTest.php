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

        //ルームIDが存在しない時
        $str_room_id = Str::random(26);
        $response = $this->get('/home/removeRoom:' . $str_room_id);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ルーム:' . $str_room_id . 'は存在しません']);

        //ログインユーザとルームの作成者が一致しない場合
        $response = $this->get('/home/removeRoom:' . $this->room_id_2);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'ログインユーザーとルームの作成者が一致しません']);

        //ルームが適切に削除される時 
        $tag_1 = Tag::factory()->create(['number' => 2]);
        $tag_2 = Tag::factory()->create(['number' => 1]);
        $tag_id_1 = $tag_1->id;
        $tag_id_2 = $tag_2->id;
        $tag_number = $tag_1->number;
        $this->rooms[0]->tags()->syncWithoutDetaching([$tag_id_1, $tag_id_2]);
        $response = $this->get('/home/removeRoom:' . $this->room_id_1);
        $this->assertDeleted($this->rooms[0]);
        //dd(Tag::find($tag_id_1)->number,$tag_number);
        $this->assertSame($tag_number - 1, Tag::find($tag_id_1)->number); //タグナンバーが２だったものは-1され１になる
        $this->assertDeleted($tag_2); //タグナンバーが１だったものを０になりテーブルから削除される
        \Storage::disk('local')->assertMissing('/roomImages/RoomID:' . $this->room_id_1);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['action_message' => 'ルーム:' . $this->room_id_1 . 'が削除されました']);
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
        //dd($room->roomChat->count());
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
        $response = $this->post('/home/room/ban/',[
            'user_id' => $user_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが発生しました']);

        //room_idが存在しない部屋のとき
        $response = $this->post('/home/room/ban/',[
            'user_id' => $user_id,
            'room_id' => Str::random(26),
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが発生しました']);

        //user_idが存在しないユーザのとき
        $response = $this->post('/home/room/ban/',[
            'user_id' => Str::random(26),
            'room_id' => $room_id
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:'.$room_id);

        //user_id が部屋の管理者のとき
        $response = $this->post('/home/room/ban/',[
            'user_id' => $user_id,
            'room_id' => $room_id,
        ]);
        $this->assertDatabaseMissing('room_bans', [
            'room_id' => $room_id,
            'user_id' => $user_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:'.$room_id);

        //部屋の管理者以外のユーザがリクエストを送ってきた時
        $user_id = $this->user->id;
        $response = $this->post('/home/room/ban/',[
            'user_id' => $user_id,
            'room_id' => $room_id,
        ]);
        $this->assertDatabaseMissing('room_bans', [
            'room_id' => $room_id,
            'user_id' => $user_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:'.$room_id);
        
        //適切にバンされる時
        $user_id = $this->other_user->id;
        $room_id = $this->room_id_1;
        Room::find($room_id)->roomUsers()->syncWithoutDetaching($user_id);
        $response = $this->post('/home/room/ban/',[
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
        $response->assertStatus(302)->assertRedirect('/home/room:'.$room_id);   
    }

    public function test_receive_lift_ban_user()
    {
        $room_id = $this->room_id_2;
        $user_id = $this->other_user->id;
        $this->actingAs($this->user); //ユーザをログイン状態へ

        //room_id 入力なしのとき
        $response = $this->post('/home/room/ban/lift',[
            'user_id' => $user_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが発生しました']);

        //room_idが存在しない部屋のとき
        $response = $this->post('/home/room/ban/lift',[
            'user_id' => $user_id,
            'room_id' => Str::random(26),
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが発生しました']);

        //user_idが存在しないユーザのとき
        $response = $this->post('/home/room/ban/lift',[
            'user_id' => Str::random(26),
            'room_id' => $room_id
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:'.$room_id);

        //user_id が部屋の管理者のとき
        $response = $this->post('/home/room/ban/lift',[
            'user_id' => $user_id,
            'room_id' => $room_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:'.$room_id);

        //部屋の管理者以外のユーザがリクエストを送ってきた時
        $user_id = $this->user->id;
        $response = $this->post('/home/room/ban/',[
            'user_id' => $user_id,
            'room_id' => $room_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:'.$room_id);
        
        //適切にリフトバンされる時
        $user_id = $this->other_user->id;
        $room_id = $this->room_id_1;
        Room::find($room_id)->roomBans()->syncWithoutDetaching($user_id);
        $this->assertDatabaseHas('room_bans', [
            'room_id' => $room_id,
            'user_id' => $user_id,
        ]);

        $response = $this->post('/home/room/ban/lift',[
            'user_id' => $user_id,
            'room_id' => $room_id,
        ]);
        
        $this->assertDatabaseMissing('room_bans', [
            'room_id' => $room_id,
            'user_id' => $user_id,
        ]);
        $response->assertStatus(302)->assertRedirect('/home/room:'.$room_id);   
    }
}
