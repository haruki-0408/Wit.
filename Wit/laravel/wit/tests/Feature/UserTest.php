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
    protected $other_user;

    public function setUp(): void
    {
        parent::setUp();
        //ユーザはメソッド毎に変わるが毎回名前だけ同じAuth,Otherというようになるので注意　$this->user->idはアクション毎に異なる
        $this->user = User::factory()->create([
            'name' => 'Auth',
        ]);
        $this->other_user = User::factory()->create([
            'name' => 'Other',
        ]);
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
            'Tag',
            'Terms',
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
        //user_idセッションがない状態でgetリクエスト
        $response = $this->get('/home/profile/settings?ref=info');
        $response->assertStatus(404);

        //セッションをつけた状態でリクエスト
        session()->put(['auth_user_id' => $this->user->id]);
        //Account Information
        $response = $this->get('/home/profile/settings?ref=info');
        $response->assertStatus(200)->assertViewIs('wit.Account.information-account');
        //Change Profile
        session()->put(['auth_user_id' => $this->user->id]);
        $response = $this->get('/home/profile/settings?ref=email');
        $response->assertStatus(200)->assertViewIs('wit.Account.change-email');
        //Delete Account
        session()->put(['auth_user_id' => $this->user->id]);
        $response = $this->get('/home/profile/settings?ref=delete');
        $response->assertStatus(200)->assertViewIs('wit.Account.delete-account');
        //refに適当な値を入れた時
        $random_string = Str::random(10);
        session()->put(['auth_user_id' => $this->user->id]);
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
        \Storage::disk('local')->deleteDirectory('/userImages/secondary:' . $this->user->id); //必ず最後は削除する
    }

    public function test_change_profile()
    {
        $this->actingAs($this->user);  //userをログイン状態にする
        $profile_image = UploadedFile::fake()->image('hoge.png');
        $response = $this->post('/home/profile/settings/changeProfile', [
            'name' => 'TestUser',
            'message' => 'hogehoge fugafuga',
            'image' => $profile_image,
        ]);
        $response->assertStatus(302);
        \Storage::disk('local')->assertExists('/userImages/secondary:' . $this->user->id);
        \Storage::disk('local')->deleteDirectory('/userImages/secondary:' . $this->user->id); //必ず最後は削除する
        $this->assertDatabaseHas('users', [
            'name' => 'TestUser',
            'profile_message' => 'hogehoge fugafuga',
        ]);
    }

    public function test_change_email()
    {
        $this->actingAs($this->user);
        //userのメールアドレスを分かりやすいものに変更
        $email = 'test@test.com';
        $this->user->email = $email;
        $this->user->email_verified_token = base64_encode($email);
        $this->user->save();

        //メールアドレスの入力がない時のバリデーションチェック
        $response = $this->post('/home/profile/settings/changeEmail', [
            'email' => '',
        ]);
        $response->assertStatus(302)->assertRedirect('/home/profile/settings?ref=email')->assertInvalid(['email']);

        //メールアドレスに@がない時のバリデーションチェック
        $response = $this->post('/home/profile/settings/changeEmail', [
            'email' => 'testtest.com',
        ]);
        $response->assertStatus(302)->assertRedirect('/home/profile/settings?ref=email')->assertInvalid(['email']);

        //メールアドレスの入力が255文字を超えた時のバリデーションチェック
        $response = $this->post('/home/profile/settings/changeEmail', [
            'email' => Str::random(256),
        ]);
        $response->assertStatus(302)->assertRedirect('/home/profile/settings?ref=email')->assertInvalid(['email']);

        //すでに登録されているメールアドレスに変更しようとした時のバリデーションチェック
        $response = $this->post('/home/profile/settings/changeEmail', [
            'email' => 'test@test.com',
        ]);
        $response->assertStatus(302)->assertRedirect('/home/profile/settings?ref=email')->assertInvalid(['email']);

        //すでに登録されているメールアドレスに変更しようとした時のバリデーションチェック
        $response = $this->post('/home/profile/settings/changeEmail', [
            'email' => 'test@test.com',
        ]);
        $response->assertStatus(302)->assertRedirect('/home/profile/settings?ref=email')->assertInvalid(['email']);

        //バリデーションが通った時
        $response = $this->post('/home/profile/settings/changeEmail', [
            'email' => 'change@test.com',
        ]);
        //email_verified_tokenが変更されていることを確認
        $new_email_verified_token = base64_encode('change@test.com');
        $this->assertDatabaseHas('users', [
            'email_verified_token' => $new_email_verified_token,
        ]);
        $response->assertViewIs('wit.Account.send-change-email');
    }

    public function test_get_inquiry_form()
    {
        $this->actingAs($this->user);

        //ここのロジックは少しややこしい$inquiry_sentenceがない状態でgetリクエストを送ると、お問い合わせフォームviewが表示される
        $response = $this->get('/home/profile/inquiry');
        $response->assertViewIs('wit.Account.inquiry-form');

        //その後お問い合わせ内容を記述し、receive_inquiry()に送信するのだが、その内容を確認するために再度引数#inquiry_sentenceとしてget_inquiry_form()へ送信する
        $inquiry_sentence = 'テストメッセージ';
        $user_controller = new UserController;
        $response = $user_controller->getInquiryForm($inquiry_sentence);
        //controllerクラスにはassert使えないので、工夫する
        $this->assertSame($response->email, $this->user->email);
        $this->assertSame($response->inquiry_sentence, $inquiry_sentence);
    }

    public function test_receive_inquiry()
    {
        $this->actingAs($this->user);

        //inquiry_sentenceの入力がない場合のバリデーションエラー
        $response = $this->post('/home/profile/inquiry/confirm', [
            'inquiry_sentence' => '',
        ]);
        $response->assertStatus(302)->assertInvalid(['inquiry_sentence']);

        //inquiry_sentenceの入力が1000文字以上の時のバリデーションエラー
        $response = $this->post('/home/profile/inquiry/confirm', [
            'inquiry_sentence' => Str::random(1001),
        ]);
        $response->assertStatus(302)->assertInvalid(['inquiry_sentence']);

        //バリデーションエラーなし
        $inquiry_sentence = 'テストメッセージ';
        $response = $this->post('/home/profile/inquiry/confirm', [
            'inquiry_sentence' => $inquiry_sentence,
        ]);
        $response->assertValid(['inquiry_sentence']);
        $response->assertStatus(200);
    }

    public function test_send_inquiry()
    {
        $this->actingAs($this->user);
        $inquiry_sentence = 'テストメッセージ';
        //inquiry_sentenceの入力がない時
        $response = $this->post('home/profile/inquiry/send', [
            'inquiry_sentence' => ''
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'お問い合わせがエラーにより送信できませんでした']);

        //inquiry_sentenceの入力がある時
        $response = $this->post('home/profile/inquiry/send', [
            'inquiry_sentence' => $inquiry_sentence,
        ]);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['action_message' => 'お問い合わせ内容が送信されました']);
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
        $user_password = User::where('name', 'Auth')->value('password');
        $this->assertTrue(Hash::check('abcdefgh', $user_password));
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
        $response = $this->post('/home/profile/settings/deleteAccount', [
            'df' => 'auth',
        ])->assertStatus(404);

        $response = $this->post('/home/profile/settings/deleteAccount', [
            'auth' => 'auth',
        ])->assertStatus(302)->assertRedirect('/');

        $this->assertDeleted($room);
        $this->assertDeleted($this->user);
        \Storage::disk('local')->assertMissing('/userImages/secondary:' . $this->user->id);
        $handle_tag = Tag::first();
        //タグナンバーが適切に-1されているか確認
        $this->assertSame($tag->number - 1, $handle_tag->number);
    }

    public function test_search_user()
    {
        $this->actingAs($this->user);  //userをログイン状態にする
        
        //keyword 入力なしのとき
        $response = $this->get('/home/searchUser?hoge=fuga');
        $response->assertStatus(404);

        //keyword 入力ありのとき 31件該当レコードがあっても30までしか取得しないことを確認
        User::factory()->count(31)->create([
            'name' => 'fugafuga',
        ]);
        $response = $this->get('/home/searchUser?keyword=fugafuga');
        $response->assertJsonCount(30);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'profile_image',
                'type',
            ]
        ]);

        //Get-More-Userの時適切に続きから取得できているか
        //ここで注意しないといけないのはuserはuuidのアルファベット順にレコードが並んでいるのでidを昇順に並べ替える。
        $order_users = User::where('name', 'fugafuga')->orderBy('id', 'asc')->get();
        $user_id = Crypt::encrypt($order_users[29]->id);
        $response = $this->get('/home/searchUser?keyword=fugafuga&user_id=' . $user_id);
        $response->assertJsonCount(1);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'profile_image',
                'type',
            ]
        ]);
    }

    public function test_get_list_user()
    {
        $this->actingAs($this->user);  //userをログイン状態にする

        //31人のテストユーザを作成し、リスト登録 最初に３０件表示されるので1件をGet-Moreで取れるように31件とする
        $users = User::factory()->count(31)->create([
            'name' => 'TestListUser',
        ]);

        //今ログインしているユーザー以外にも同じく31件のリストユーザーを登録させる Other-List-Userのテスト
        $other_favorite_users = User::factory()->count(31)->create([
            'name' => 'TestOtherListUser',
        ]);
        foreach ($users as $user) {
            $this->user->listUsers()->syncWithoutDetaching($user->id);
        }

        foreach ($other_favorite_users as $other_favorite_user) {
            $this->other_user->listUsers()->syncWithoutDetaching($other_favorite_user->id);
        }

        //ログイン中のユーザーリストが取得できているか
        $response = $this->get('/getListUser');
        $response->assertJsonCount(30);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'profile_image',
                'type',
            ]
        ]);

        //Get-More-User であぶれた１件がきちんと取得できているか
        $favorite_users = $this->user->listUsers()->orderBy('list_users.id', 'asc')->take(2)->get();
        $favorite_user_id = Crypt::encrypt($favorite_users[1]->id);
        $response = $this->get('/getListUser:' . $favorite_user_id);
        $response->assertJsonCount(1);
        $response->assertJsonStructure([
            '0' => [  //Get_Moreの最後のユーザにはきちんとno_get_moreフラグがついているかテスト
                'id',
                'name',
                'profile_image',
                'type',
                'no_get_more',
            ]
        ]);

        //他人のリストが取得できているか Other-More-Userの機能をテストする
        $other_favorite_users = $this->other_user->listUsers()->orderBy('list_users.id', 'asc')->take(16)->get();
        $other_favorite_user_id = Crypt::encrypt($other_favorite_users[15]->id);
        $other_user_id = Crypt::encrypt($this->other_user->id);
        $response = $this->get('/getListUser:' . $other_favorite_user_id . '/' . $other_user_id);
        $response->assertJsonCount(15);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'profile_image',
                'type',
            ]
        ]);
        $response->assertJsonStructure([
            '14' => [   //Other_Moreの最後のユーザにはきちんとno_get_moreフラグがついているかテスト
                'id',
                'name',
                'profile_image',
                'no_get_more',
            ]
        ]);
    }

    public function test_action_add_list_user()
    {
        $this->actingAs($this->user);  //userをログイン状態にする

        //存在しないユーザIDを送信した時
        $random_user_id = Crypt::encrypt(Str::random(10));
        $response = $this->get('/home/addListUser:' . $random_user_id);
        $response->assertJsonPath('error_message', 'そのユーザは存在しません');

        //存在しているがすでにユーザーがリストに登録されている時
        $this->user->listUsers()->syncWithoutDetaching($this->other_user->id);
        $other_user_id = Crypt::encrypt($this->other_user->id);
        $response = $this->get('/home/addListUser:' . $other_user_id);
        $response->assertJsonPath('error_message', 'そのユーザは既にリストに登録されています');

        //ユーザが適切にリストに登録された時
        $list_user = User::factory()->create();
        $list_user_id = Crypt::encrypt($list_user->id);
        $response = $this->get('/home/addListUser:' . $list_user_id);
        $response->assertJsonPath('message', 'リストにユーザーを追加しました');
    }

    public function test_action_remove_list_user()
    {
        $this->actingAs($this->user);  //userをログイン状態にする

        //存在しないユーザIDを送信した時
        $random_user_id = Crypt::encrypt(Str::random(10));
        $response = $this->get('/home/removeListUser:' . $random_user_id);
        $response->assertJsonPath('error_message', 'そのユーザはリストに登録されていません');

        //ユーザーが適切にリストから登録解除された時
        $this->user->listUsers()->syncWithoutDetaching($this->other_user->id);
        $other_user_id = Crypt::encrypt($this->other_user->id);
        $response = $this->get('/home/removeListUser:' . $other_user_id);
        $response->assertJsonPath('message', 'リストからユーザーを削除しました');

        //存在しているがユーザがリストに登録されていない時
        $list_user = User::factory()->create();
        $list_user_id = Crypt::encrypt($list_user->id);
        $response = $this->get('/home/removeListUser:' . $list_user_id);
        $response->assertJsonPath('error_message', 'そのユーザはリストに登録されていません');
    }
}
