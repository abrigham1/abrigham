#!/usr/bin/env bash

# move
cd /opt/codedeploy-agent/deployment-root/$DEPLOYMENT_GROUP_ID/$DEPLOYMENT_GROUP_ID/

# run composer install this also runs php artisan optimize
# composer install --no-dev --optimize-autoloader --no-interaction

# clear our caches and cache our routes and config
php /opt/codedeploy-agent/deployment-root/$DEPLOYMENT_GROUP_ID/$DEPLOYMENT_GROUP_ID/artisan cache:clear
php /opt/codedeploy-agent/deployment-root/$DEPLOYMENT_GROUP_ID/$DEPLOYMENT_GROUP_ID/artisan view:clear
php /opt/codedeploy-agent/deployment-root/$DEPLOYMENT_GROUP_ID/$DEPLOYMENT_GROUP_ID/artisan route:cache
php /opt/codedeploy-agent/deployment-root/$DEPLOYMENT_GROUP_ID/$DEPLOYMENT_GROUP_ID/artisan config:cache

# install npm dependencies
#npm install

# run production assets
#npm run prod

# run artisan down on the codebase note we are currently in a tmp deploy directory
# so we need to give a path to the actual directory
#
# Typically this would happen during ApplicationStop however because we have to run npm install
# composer install and npm run prod and we can't run those in ApplicationStop because the
# tmp directory to hold the revision is not created yet we are instead putting this here
# so it can happen after those costly operations thus saving us downtime
#php /var/www/sites/abrigham/artisan down

# run any migrations necessary the application is down now
# currently we have no database or migrations so this is commented out
# php artisan migrate