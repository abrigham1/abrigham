#!/usr/bin/env bash

# switch to laradock directory
cd `dirname "$(readlink -f "$0")"`/../laradock

# bring up workspace if its not already up
docker-compose up -d workspace

# install production
docker-compose exec -T --user=laradock workspace bash -c "composer install --no-dev --optimize-autoloader --no-interaction --quiet && npm install --quiet && npm run prod && php artisan clear-compiled && php artisan route:clear && php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan route:cache && php artisan config:cache"

# stop the docker containers
docker-compose stop

# switch to project base directory
cd `dirname "$(readlink -f "$0")"`/../

# swap to production env
mv .env .env.local
mv .env.production .env
