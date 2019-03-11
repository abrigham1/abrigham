#!/usr/bin/env bash

# copy .env.example to .env if it doesn't exist
if [ ! -f ./.env ]; then
    cp ./.env.example ./.env
fi

# copy env-example to .env if it doesn't exist for laradock
if [ ! -f ./laradock/.env ]; then
    cp ./laradock/env-example ./laradock/.env
fi