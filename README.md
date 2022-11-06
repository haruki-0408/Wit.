# __アプリケーション__ 
<div style="text-align:center; display:flex; font-size:18px;" align="center">
    <img width="30" alt="App-Image" src="https://user-images.githubusercontent.com/94882349/199984199-b67c9366-db95-40e2-8876-b8d415ec7f00.PNG">&nbspWit.
</div>

### URL : https://www.wit-dot.com 
<br/>
<br/>

# __概要__
質問したい内容や知りたい情報をリアルタイムで解決できるSNSアプリケーション<br>
雑談や議論等のコミュニティの作成も可能
<br/>
<br/>

# __お試し用アカウント__
## Email : test1@wit-dot.com<br>
## Password : test1111
<br/>
<br/>

# __やりたかったこと__
## 
    ①Q&A系アプリケーションは前例が多く存在し、Webアプリケーションに関する基本的知識や実装が学べるのではないか
    ②前例の多くは質問と回答の間にページ読み込みが発生するので、速応性に欠け、いつ回答がくるか予測できない
    ③１質問ー１回答のやり取りでは思惑どおりの回答が得られず質問が終了してしまう
    ④機能の複雑化によりユーザがアプリ使用の第一歩を踏みとどまってしまうのを避けたい
##   
    ①前例が多く、Webアプリケーションに関する基本的知識や実装が学べると考えた
    ②質問をタイムライン形式で表示し、リアルタイムチャット機能を用いてルームという単位に分けることにより誰がいつ入ってきたかを認識し、質問のタイミングをとりやすくできる
    ③会話形式で質問を行えるので質問回答への補足がしやすく質問者と回答者での認識のずれをその場で無くし、質問者が具体的に解決したい問題を把握できるので明確な回答が得られやすい
    ④会話機能以外の余分な機能をできるだけ減らし、シンプルかつスタイリッシュにしたい！
<br/>



# __開発環境__
## 使用技術
    ・Docker v20.10.17 (docker-compose v2.6.1)
        ・php-fpm 8.0
            ・Laravel 8.83
            ・cron (Laravelコマンドのタイムスケジュールに使用)
        ・nginx 
        ・MySQL 8.0 (テスト用DBと開発用DBのコンテナを作成)
        ・phpmyadmin (DB管理)
    ・ngrok (localhost にPusherからのWebhookを受信させるため)
    ・Pusher (リアルタイムチャットAPI)
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
    ・list_users - ユーザが自分のリストに登録したユーザを管理
    ・list_rooms - ユーザが自分のリストに登録したルームを管理
    ・room_chat - ルームに投稿されたチャットメッセージを管理
    ・room_bans - ルームのアクセス禁止ユーザを管理
    ・sessions - セッション機能を管理
    ・personal_access_token - 

<img width="945" alt="ER diagram" src="https://user-images.githubusercontent.com/94882349/199980384-f027f64b-ed2b-48c9-8b2d-fb32a234795b.png">
<br/>
<br/>