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

*Optionnel: Pour un passage en production, remplacez les variables correspondantes par celle-ci*

```.env
APP_DEBUG=true
APP_ENV=production
```


## Compte administrateur (Non utilisé)

Par défault, les credentials pour le compte administrateur sont:

```text
Name: Administrator
E-mail: admin@example.com
Password: password
```

Vous pouvez néanmoins le personnaliser dans le fichier .env:

```.env
ADMIN_NAME=""
ADMIN_EMAIL=""
ADMIN_PASSWORD=""
```
