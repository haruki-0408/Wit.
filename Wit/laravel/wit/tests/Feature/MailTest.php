<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Mail\Subscribe;
use App\Mail\Inquiry;
use App\Mail\ChangeEmail;
use App\Models\User;
use Tests\TestCase;

class MailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_inquiry()
    {
        $user = User::factory()->create();
        $inquiry_sentence = 'テストメッセージです';
        $mailable = new Inquiry($user, $inquiry_sentence);
        $mailable->assertSeeInHtml('ユーザからのお問い合わせがありました。'); //件名は探されない
        $mailable->assertSeeInHtml($user->name); //件名は探されない
        $mailable->assertSeeInHtml($user->created_at);
        $mailable->assertSeeInHtml($user->email);
        $mailable->assertSeeInHtml($inquiry_sentence);
    }

    public function test_change_email()
    {
        $user = User::factory()->create();
        $user->email_verified_token = base64_encode('test1111@test.com');
        $user->save();
        $mailable = new ChangeEmail($user);
        $mailable->assertSeeInHtml('/email/verify/'.$user->email_verified_token);
        $mailable->assertSeeInHtml('本メールは、あなたのWit. アカウントのメールアドレス変更リクエストを受け取ったためにお送りしています。');
    }

    public function test_subscribe()
    {
        $user = User::factory()->create();
        $user->email_verified_token = base64_encode('test1111@test.com');
        $user->save();
        $mailable = new Subscribe($user);
        $mailable->assertSeeInHtml('/register/verify/'.$user->email_verified_token);
        $mailable->assertSeeInHtml('Wit.へのアカウント仮登録が完了しました');
    }
}
