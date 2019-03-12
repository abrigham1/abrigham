#!/usr/bin/env bash

# switch to laradock directory
cd `dirname "$(readlink -f "$0")"`/../laradock/

# bring up workspace if its not already up
docker-compose up -d workspace

# install local
docker-compose exec -T --user=laradock workspace bash -c "composer install --no-interaction --quiet && npm install --quiet && npm run dev && php artisan clear-compiled && php artisan route:clear && php artisan config:clear && php artisan cache:clear && php artisan view:clear"

# stop the docker containers
docker-compose stop

# switch to project base directory
cd `dirname "$(readlink -f "$0")"`/../

# swap to local env
mv .env .env.production
mv .env.local .env