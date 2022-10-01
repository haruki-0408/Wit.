@component('mail::message')
#こんにちは
本メールは、あなたのWit. アカウントのパスワードリセットリクエストを受け取ったためにお送りしています。<br>
@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

このパスワードリセットリンクは {{ $count }}分後に有効期限が切れます。<br>

# 上記リンクをクリックできない場合は、以下の URL をあなたのウェブブラウザにコピーして貼り付けてください。
    {{ url($url) }}


本メールにお心当たりのない方はお手数ですが破棄して下さい。<br>
{{ config('app.name') }}
@endcomponent