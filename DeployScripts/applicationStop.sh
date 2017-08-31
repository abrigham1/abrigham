#!/usr/bin/env bash

# applicationStop on aws always runs on the previous version of your code before deployment of the new code occurs
# take that into account when adding commands here because they will only be run on the deployment after they
# are originally deployed

# move to our application directory
cd /var/www/sites/abrigham

# put the application in maintenance mode
php artisan down

# clear cached (bootstrap/cache/) files have to do this now because when we deploy we may have
# a new version of laravel that no longer agrees with them
php artisan clear-compiled
php artisan route:clear
php artisan config:clear
