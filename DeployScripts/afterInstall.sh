#!/usr/bin/env bash

# move to our application directory
cd /var/www/sites/abrigham

php artisan cache:clear
php artisan view:clear
php artisan route:cache
php artisan config:cache

# this is where we would run migrations however we currently have none
#php artisan migrate