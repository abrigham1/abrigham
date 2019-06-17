#!/usr/bin/env bash

# copy .env.example to .env if it doesn't exist
if [ ! -f ./.env ]; then
    cp ./.env.example ./.env
    echo "Successfully copied .env.example to .env"
else
    echo ".env already exists nothing to copy"
fi

# copy env-example to .env if it doesn't exist for laradock
if [ ! -f ./laradock/.env ]; then
    cp ./laradock/env-example ./laradock/.env
    echo "Successfully copied ./laradock/env-example to ./laradock/.env"
else
    echo "./laradock/.env already exists nothing to copy"
fi