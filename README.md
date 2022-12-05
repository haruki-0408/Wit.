# __アプリケーション__ 
<div style="text-align:center; display:flex; font-size:18px;" align="center">
    <img width="30" alt="App-Image" src="https://user-images.githubusercontent.com/94882349/199984199-b67c9366-db95-40e2-8876-b8d415ec7f00.PNG">&nbspWit.
</div>

### URL : https://www.wit-dot.com 
<br/>
<br/>

# __概要__
質問したい内容や問題をリアルタイムで解決できるアプリケーション<br>
<br/>
<br/>

# __お試し用アカウント__
## Email : test1@wit-dot.com<br>
## Password : test1111
<br/>
<br/>

# __目的__
## 
    ・Webアプリケーションとして一通りの機能を実装するため自分でよく使用していたQ&A系を作成してみたかった。
    ・世に出ているQ&A系アプリケーションは１質問-１回答で終わっていることが多いと感じたので、複数人との会話形式にすることによって質問者の問題を解決しやすいようにしたかった。
    ・ユーザがルームに入室し、問題が解決するまでの過程を会話として残すことで後から同じ内容で困っている人の参考になり、
    　議論や雑談などのコミュニティアプリとしての汎用性も持たせることができると考えた。
##    
<br/>

# __開発環境__
## 使用技術
    ・Docker v20.10.17 (docker-compose v2.6.1) 
    ・php-fpm 8.0
    ・Laravel 8.83
    ・nginx 
    ・MySQL 8.0 (テスト用DBと開発用DBのコンテナを作成)
    ・phpmyadmin (DB管理)
    ・ngrok (localhost にPusherからのWebhookを受信させるため)
    ・cron (Laravelのタイムスケジュール機能を実行するため)
    ・Pusher (リアルタイムチャット機能を外部APIにて実現)
    ・Bootstrap 5 & Bootstrap Icon (CSSプラグイン & アイコン) 
    ・jQuery (ajax等)
    ・Git (コード管理)

## ファイル構成
<img width="264" alt="FileTree" src="https://user-images.githubusercontent.com/94882349/199989238-a78a12fe-bcc2-4269-a8cb-b5609bae3474.png">
<br/>
<br/>


<img width="899" alt="dev_env" src="https://user-images.githubusercontent.com/94882349/198312449-20115fc7-0859-4747-81af-69cbbfa7ed2f.png">
<br/>
<br/>


# __本番環境__
## AWS
インフラ周りを自動デプロイも兼ねてAWSで構築

・EC2 (laravel&nginxをインストール)<br/>
・ACM (SSLのための証明書取得)<br/>
・Route53 (独自ドメインの管理) <br/>
・RDS (MySQL環境でALBを通してEC2と通信)<br/>
・Code Pipeline (GitHubのmainにpushするとCode Deployが作動)<br/>
・Code Deploy (CodePipelineから通知を受け取りEC2内にデプロイ)<br/>
・S3 (デプロイ用コード保管用)<br/>

![prod_env drawio](https://user-images.githubusercontent.com/94882349/199009382-41b5ac2c-7bca-47ff-beb2-910ef5d2d254.png)
<br/>
<br/>

# __データベース__
## テーブル
    ・users - ユーザを管理
    ・rooms - ルームを管理
    ・tags - タグ登録を管理
    ・room_users - ルームに入室しているユーザを管理
    ・room_images - ルームに投稿された画像を管理
    ・room_tags - ルームに登録されたタグを管理
    ・list_users - ユーザのリストに登録されたユーザを管理
    ・list_rooms - ユーザのリストに登録されたルームを管理
    ・room_chat - ルームに投稿されたチャットメッセージ、ファイルを管理
    ・room_bans - ルームのアクセス禁止ユーザを管理
    ・sessions - ユーザのセッション機能を管理
    ・password_resets - パスワードを忘れた際のトークン付与

<img width="1019" alt="Wit ER diagram" src="https://user-images.githubusercontent.com/94882349/203037571-e165241c-6724-4a03-b345-ef0c43620ed4.png">
<br/>
<br/>

# __機能一覧__
①ユーザ登録&編集機能<br>
・メールアドレス、パスワードによる新規登録とログイン機能<br>
・ユーザ名、プロフィール画像、メッセージ、メールアドレス、パスワードの編集機能<br>
・ユーザ退会、アカウント削除機能<br>
・他ユーザをリスト(お気に入り)に登録、解除できる機能<br>
<br>
<br>
②ルーム(質問)作成機能<br>
・質問したい内容をTitleとDescriptionに分け記述し、その問題を解決するためのルームを作成できる機能<br>
・質問をわかりやすくするための画像投稿機能<br>
・ルームにパスワードを付与し、プライベートモードにする機能<br>
・ルームに有効期限を設け保存、削除する機能<br>
・他ルームをリスト(お気に入り)に登録、解除できる機能<br>
・ルームの削除機能<br>
<br>
<br>
③ルーム内機能<br>
・ページのリロードを挟まないリアルタイムチャット機能<br>
・チャット画面によるファイルアップロード、画像アップロード<br>
・ユーザのルーム入室、退室をお知らせ、認識できる機能<br>
・会話形式で問題にアプローチするのでどのメッセージが解決につながったかを判別させる機能(メッセージ強調表示)<br>
・悪質なユーザをルームにアクセス禁止にするバン機能とその解除機能<br>
・ルームを保存し、それまでの会話記録を閲覧できる機能<br>
<br>
<br>
④タグ登録機能<br>
・ルーム作成時に複数個タグを登録し、自由にカテゴライズできる機能<br>
<br>
<br>
⑤検索機能<br>
・ルーム内の文面から検索できるキーワード検索<br>
・ルームのIDでルームを特定するID検索<br>
・ルームに登録されているタグを検索するタグ検索<br>
・ユーザ名を用いてのユーザ検索<br>
・画像あり、パスワードありなどの各種検索フィルター<br>
・ページのリロードを含まないボタンプッシュ式追加ページの表示<br>
<br/>
<br/>
⑥レスポンシブ対応<br/>
・PCをメインにスマホ、タブレット各種画面サイズの表示分け
<br/>
<br/>

# __力をいれた点__
    ・Dockerによる開発インフラ環境構築  
    ・AWSによる本番インフラ環境構築
    ・サーバー負荷軽減(ページ表示制限、ルーム最大接続人数制限、ファイルアップロードサイズ制限)
    ・パスワード付きのルームに対してのセキュリティ(不正入室禁止、画像閲覧禁止など)
    ・ユーザの動作をできるだけ予想したバリデーションや2重アクションの制限
    ・全コントローラ、ルーティングに対してのFeatureテストコードの作成
<br/>
<br/>

# __もう少し実現したかった点__
    ・もう少し質問-回答をしやすい、画期的な報酬制度を入れたかった。
    ・javascriptのフレームワークを用いての構築
<br/>
<br/>



