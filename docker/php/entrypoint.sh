#!/bin/bash

cd /var/www

[ ! -f .env ] && cp .env.example .env

[ ! -f .env.testing ] && cp .env.example .env.testing

composer install

npm install
yarn install
yarn build

php artisan key:generate
php artisan key:generate --env=testing

php artisan migrate:fresh --seed

exec php-fpm
