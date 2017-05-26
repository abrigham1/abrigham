#!/usr/bin/env bash

# run composer install this also runs a number of other commands from the composer.json file
# php artisan optimize
# php artisan cache:clear
# php artisan view:clear
# php artisan route:cache
# php artisan config:cache
# npm install
# npm run prod
composer install --no-dev --optimize-autoloader --prefer-source --no-interaction

# run artisan down on the codebase note we are currently in a tmp deploy directory
# so we need to give a path to the actual directory
#
# Typically this would happen during ApplicationStop however because we have to run npm install
# composer install and npm run prod and we can't run those in ApplicationStop because the
# tmp directory to hold the revision is not created yet we are instead putting this here
# so it can happen after those costly operations thus saving us downtime
php /var/www/sites/abrigham/artisan down

# run any migrations necessary the application is down now
# currently we have no database or migrations so this is commented out
# php artisan migrate