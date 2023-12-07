# Blog Laravel-Vue: API

## Setup

Voici l'étape à suivre pour utiliser l'API en local (http://localhost:8000/api)

```sh
git clone https://github.com/antoinelrk/blog-laravel-api.git
cd ./blog-laravel-api

cp .env.example .env

composer install -o

php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```
