<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\UserController;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Room;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    //実際のルーティング等で通信を行うメソッドはすべてFeature Testに記述する
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }


    public function test_show_profile()
    {
        $this->actingAs($this->user);  //userをログイン状態にする
        $user_id = Crypt::encrypt($this->user->id);
        $response = $this->get('/home/profile:' . $user_id);
        $response->assertStatus(200)->assertViewIs('wit.profile');
        $response->assertSee([ //response htmlに以下の文字列が含まれているか
            $this->user->profile_image,
            $this->user->name,
            $this->user->profile_message,
            'Open',
            'Post',
            'List User',
            'List Room',
            'Trend Tag',
        ]);
        $response->assertViewHasAll([ //responseに以下のデータが存在しているか
            'user_id',
            'type',
            'user_name',
            'profile_message',
            'profile_image',
        ]);
    }

    public function test_profile_settings()
    {
        $this->actingAs($this->user);  //userをログイン状態にする
        $response = $this->get('/home/profile/settings?ref=info');
        $response->assertStatus(200)->assertViewIs('wit.Account.information-account');

        $response = $this->get('/home/profile/settings?ref=delete');
        $response->assertStatus(200)->assertViewIs('wit.Account.delete-account');

        $random_string = Str::random(10);
        $response = $this->get('/home/profile/settings?ref=' . $random_string);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが起きました']);
    }

    public function test_auth_password_info()
    {
        $this->actingAs($this->user);  //userをログイン状態にする
        //パスワードが存在しない時
        $response = $this->post('/home/profile/settings/authUserPassword', [
            'ref' => 'info',
        ]);
        $response->assertInvalid(['information_password']);

        //パスワードが間違っている時
        $response = $this->post('/home/profile/settings/authUserPassword', [
            'ref' => 'info',
            'information_password' => '12345',
        ]);
        $response->assertInvalid(['information_password']);

        //パスワードが一致している時
        $response = $this->post('/home/profile/settings/authUserPassword', [
            'ref' => 'info',
            'information_password' => 12345678,
        ]);
        $response->assertValid(['information_password']);
        $response->assertStatus(200);
    }

    public function test_auth_password_delete()
    {
        $this->actingAs($this->user);  //userをログイン状態にする
        //パスワードが存在しない時
        $response = $this->post('/home/profile/settings/authUserPassword', [
            'ref' => 'delete',
        ]);
        $response->assertInvalid(['delete_password']);

        //パスワードが間違っている時
        $response = $this->post('/home/profile/settings/authUserPassword', [
            'ref' => 'delete',
            'delete_password' => '12345',
        ]);
        $response->assertInvalid(['delete_password']);

        //パスワードが一致している時
        $response = $this->post('/home/profile/settings/authUserPassword', [
            'ref' => 'delete',
            'delete_password' => 12345678,
        ]);
        $response->assertValid(['delete_password']);
        $response->assertStatus(200);
    }

    public function test_store_image()
    {
        $user_controller = new UserController;
        $this->actingAs($this->user);  //userをログイン状態にする
        $upload_file = UploadedFile::fake()->image('fuga.jpg');
        $response = $user_controller->storeImage($upload_file);
        //適切にストレージにユーザー画像が保存されているかテスト
        \Storage::disk('local')->assertExists($response);
    }

    public function test_change_profile()
    {
        $user_id = Crypt::encrypt($this->user->id);
        $this->actingAs($this->user);  //userをログイン状態にする
        $profile_image = UploadedFile::fake()->image('hoge.png');
        $response = $this->post('/home/profile/settings/changeProfile', [
            'name' => 'TestUser',
            'email' => 'test@test.com',
            'message' => 'hogehoge fugafuga',
            'image' => $profile_image,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'name' => 'TestUser',
            'email' => 'test@test.com',
            'profile_message' => 'hogehoge fugafuga',
        ]);
    }

    public function test_change_password()
    {
        $this->actingAs($this->user);  //userをログイン状態にする

        //入力なし
        $response = $this->post('/home/profile/settings/changePassword', []);
        $response->assertInvalid(['current_password', 'new_password']);

        //バリデーションエラー
        $response = $this->post('/home/profile/settings/changePassword', [
            'current_password' => '123456',
            'new_password' => '123',
            'new_passwprd_confirmation' => '12345',
        ]);
        $response->assertInvalid(['current_password', 'new_password']);

        //バリデーションクリア
        $response = $this->post('/home/profile/settings/changePassword', [
            'current_password' => 12345678,
            'new_password' => 'abcdefgh',
            'new_password_confirmation' => 'abcdefgh',
        ]);
        $response->assertValid(['current_password', 'new_password_confirmation']);
        $response->assertStatus(302)->assertSessionHas(['action_message' => 'パスワードを変更しました']);
        //$this->assertTrue(Hash::check('abcdefgh', $this->user->password));
    }

    public function test_delete_account()
    {
        $this->actingAs($this->user);  //userをログイン状態にする
        $room = Room::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Test Room',
            'description' => 'Use Feature Test',
        ]);
        $tag = Tag::factory()->create();
        $tag_id = $tag->id;
        $room->tags()->syncWithoutDetaching($tag_id);
        $this->assertDatabaseHas('rooms', [
            'user_id' => $this->user->id,
            'title' => 'Test Room',
            'description' => 'Use Feature Test',
        ]);
        $response = $this->post('/home/profile/settings/deleteAccount');
        $response->assertStatus(302)->assertRedirect('/');
        $this->assertDeleted($room);
        $this->assertDeleted($this->user);
        
        



    }
}
