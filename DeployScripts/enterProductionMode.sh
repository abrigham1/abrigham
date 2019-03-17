#!/usr/bin/env bash

# switch to laradock directory
cd `dirname "$(readlink -f "$0")"`/../laradock

# install production
docker-compose run -u laradock workspace bash -c "composer install --no-dev --optimize-autoloader --no-interaction --no-suggest --no-progress && npm install --quiet && npm run prod && php artisan clear-compiled && php artisan route:clear && php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan route:cache"