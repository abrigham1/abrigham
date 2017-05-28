#!/usr/bin/env bash

# move to our application directory
cd /var/www/sites/abrigham

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

# run any migrations necessary the application is down now
# currently we have no database or migrations so this is commented out
# php artisan migrate