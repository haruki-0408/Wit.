@component('mail::message')
# Wit.へのアカウント仮登録が完了しました
以下のリンクから本登録を完了させて下さい<br>
@component('mail::button', ['url' => url('/register/verify/'.$token)])
Register
@endcomponent

このリンクは約60分後に有効期限が切れます。<br>
期限が切れた場合、お手数ですがはじめからやり直して下さい。<br>

# 上記リンクをクリックできない場合は、以下の URL をあなたのウェブブラウザにコピーして貼り付けてください。
    {{ url('/register/verify/'.$token) }}


本メールにお心当たりのない方はお手数ですが破棄して下さい。<br>
{{ config('app.name') }}
@endcomponent