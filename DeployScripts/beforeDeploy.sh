#!/usr/bin/env bash

# run composer install this also runs php artisan optimize
composer install --no-dev --optimize-autoloader --no-interaction

# clear our caches and cache our routes and config
php artisan cache:clear
php artisan view:clear
php artisan route:cache
php artisan config:cache

# install npm dependencies
npm install

# run production assets
npm run prod

# zip our latest revision to upload to s3
zip -r latest *
mkdir -p cd_upload
mv latest.zip cd_upload/latest.zip