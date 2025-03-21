confirmation-test
環境構築
Dockerビルド

git@github.com:Akichq/confirmation-test.git
docker-compose up -d --build

※ MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせて docker-compose.yml ファイルを編集してください。
Laravel環境構築

docker-compose exec php bash
composer install
.env.exampleファイルから.envを作成し、環境変数を変更
php artisan key
php artisan migrate
php artisan db

使用技術

PHP 8.4.5
Laravel 8.83.29
MySQL 8.0

URL

開発環境：http://localhost/
phpMyAdmin：http://localhost:8080/