# __アプリケーション__ 
<div style="text-align:center; display:flex; font-size:18px;" align="center">
    <img width="30" alt="App-Image" src="https://user-images.githubusercontent.com/94882349/199984199-b67c9366-db95-40e2-8876-b8d415ec7f00.PNG">&nbspWit.
</div>

### URL : https://www.wit-dot.com 
<br/>
<br/>

# __概要__
質問したい内容や問題をリアルタイムで解決でき、雑談や議論等のコミュニティの作成も可能なアプリケーション<br>
<br/>
<br/>

# __お試し用アカウント__
## Email : test1@wit-dot.com<br>
## Password : test1111
<br/>
<br/>

# __目的__
## 
    リアルタイムチャットの機能を用いて、会話形式でユーザの質問や問題を解決できるアプリケーションを作ったみたら面白いと考えた。
    1質問-1回答で終わらないので質問者-回答者の双方の認識のずれを減らし、明確な回答が得られやくしたかった。
    ユーザがルームに入室し、問題が解決するまでの過程を残すことで、後から同じ内容で困っている人の参考になると考えた。
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
・Code Pipeline (GitHubのmainにpushすると通知)<br/>
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
    ・sessions - セッション機能を管理

<img width="1019" alt="Wit ER diagram" src="https://user-images.githubusercontent.com/94882349/203037571-e165241c-6724-4a03-b345-ef0c43620ed4.png">
<br/>
<br/>

# __機能一覧__
①ユーザ登録&編集機能
 
②