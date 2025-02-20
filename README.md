# coachtechフリマ

## 概要
アイテムの出品と購入を行うためのフリマアプリです。

## 主な機能
新規会員登録
ログイン
ログアウト
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
phpmyadmin:http://localhost:8080/index.php

## セットアップ
1. リポジトリをクローン
ディレクトリ以下に、furima.gitをクローンしてリポジトリ名をfurimaTestに変更しましょう。

git clone git@github.com:ryota10-ten/furima.git
mv furima furimaTest

2. Docker の設定
docker-compose up -d --build
code .

furimaコンテナが作成されていれば成功です。

3. Laravel のパッケージのインストール
docker-compose exec php bash
composer install

4. .env ファイルの作成
cp .env.example .env
.env.example をコピーして .env を作成。


5. サーバーを起動
ブラウザで
http://localhost/
にアクセスするとアプリを確認できます。







