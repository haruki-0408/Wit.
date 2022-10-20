@component('mail::message')
# こんにちは
本メールは、あなたのWit. アカウントのメールアドレス変更リクエストを受け取ったためにお送りしています。<br>
@component('mail::button', ['url' => url('/email/verify/'.$token)])
Change Email
@endcomponent

上記メールアドレス変更リンクをクリックし、メールアドレスの変更登録を完了して下さい<br>

# 上記リンクをクリックできない場合は、以下の URL をあなたのウェブブラウザにコピーして貼り付けてください。
    {{ url('/email/verify/'.$token) }}


本メールにお心当たりのない方はお手数ですが破棄して下さい。<br>
{{ config('app.name') }}
@endcomponent