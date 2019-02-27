#!/usr/bin/env bash

# copy .env.example to .env if it doesn't exist
if [ ! -f ./.env ]; then
    cp ./.env.example ./.env
fi

# copy env-example to .env if it doesn't exist for laradock
if [ ! -f ./laradock/.env ]; then
    cp ./laradock/env-example ./laradock/.env
fi

# copy abrigham.conf.example to abrigham.conf if it doesn't exist for laradock
# needed to serve the laravel site at abrigham.localhost
if [ ! -f ./laradock/nginx/sites/abrigham.conf ]; then
    cp ./laradock/nginx/sites/abrigham.conf.example ./laradock/nginx/sites/abrigham.conf
fi

# copy mlapi.conf.example to mlapi.conf if it doesn't exist for laradock
# needed to serve the movie review classifier at mlapi.abrigham.localhost
if [ ! -f ./laradock/nginx/sites/mlapi.conf ]; then
    cp ./laradock/nginx/sites/mlapi.conf.example ./laradock/nginx/sites/mlapi.conf
fi