# coachtechフリマ

## 概要
アイテムの出品と購入を行うためのフリマアプリです。

## 主な機能
新規会員登録
ログイン機能
ログアウト機能
出品した商品以外の商品一覧取得
いいねをした商品一覧取得
商品検索
商品詳細情報取得
商品に対してのいいね送信機能
商品に対してのコメント送信機能

## 使用技術
laravel=8.*
php:7.4.9-fpm
mysql:8.0.26
nginx:1.21.1

## 開発環境
トップページ:http://localhost/
会員登録ページ:http://localhost/register
phpmyadmin:http://localhost:8080/index.php

## セットアップ
1. リポジトリをクローン
ディレクトリ以下に、furima.gitをクローンしてリポジトリ名をfurimaTestに変更。

git clone git@github.com:ryota10-ten/furima.git
mv furima furimaTest
cd furimaTest

2. Docker の設定
docker compose up -d --build
code .

furimatestコンテナが作成されていれば成功です。

3. Laravel のパッケージのインストール
docker compose exec php bash
composer install

4. .env ファイルの作成
cp .env.example .env
.env.example をコピーして .env を作成。

※メール送信の設定（Mailtrap）
（１）Mailtrap のアカウント作成
Mailtrap の公式サイト（https://mailtrap.io/）にアクセスし、無料アカウントを作成してください。

（２）Mailtrap の SMTP 設定を取得
Mailtrap にログイン後、Inbox を作成
Start Testing を開く

Laravel 7+ and 8.Xの設定を選択
.env に以下の情報を設定

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="Furima App"

MAIL_USERNAME と MAIL_PASSWORD には Mailtrap のダッシュボードで確認できる値を入力してください。

決済機能の設定（Stripe）
（１）Stripe のアカウント作成
Stripe の公式サイト（https://stripe.com/jp）にアクセスし、無料アカウントを作成
Stripe の ダッシュボード にログイン
「開発者」モードを有効化（テスト環境用 API キーを取得するため）

（２）Stripe ダッシュボードの 「APIキー」 セクションへ移動
以下の 2 つのキーを取得
公開可能キー（Publishable key）
シークレットキー（Secret key）

.env ファイルを開き、以下の Stripe 設定を追加または変更してください。
STRIPE_KEY=your_publishable_key
STRIPE_SECRET=your_secret_key

※ your_publishable_key と your_secret_key には Stripe ダッシュボードで取得した値を入力してください。
本番環境では、本番用の API キー に変更してください（テストキーと本番キーは異なります）。

5. アプリキーの生成
以下のコマンドを実行して、アプリケーションの暗号化キーを生成してください。
php artisan key:generate

6. マイグレーションとシーディングの実装
php artisan migrate
php artisan db:seed

5. サーバーを起動

php artisan serve
ブラウザで
http://localhost/
にアクセスするとアプリを確認できます。


<img width="876" alt="スクリーンショット 2025-02-20 11 04 37" src="https://github.com/user-attachments/assets/5fa53da1-0c3f-4b65-b644-bcfdea26d0bc" />







