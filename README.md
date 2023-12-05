# Blog Laravel-Vue: API

## Setup

```sh
cp .env.example .env
```

*Optionnel: Pour un passage en production, remplacez les variables correspondantes par celle-ci*

```.env
APP_DEBUG=true
APP_ENV=production
```

```sh
composer install -o
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```

## Compte administrateur

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
