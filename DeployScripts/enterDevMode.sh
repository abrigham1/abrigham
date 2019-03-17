#!/usr/bin/env bash

# switch to laradock directory
cd `dirname "$(readlink -f "$0")"`/../laradock/

# install local
docker-compose run --rm -u laradock workspace bash -c "composer install --no-interaction --no-progress --no-suggest && npm install --quiet && npm run dev && php artisan clear-compiled && php artisan route:clear && php artisan config:clear && php artisan cache:clear && php artisan view:clear"