# abrigham.com
[![Build Status](https://travis-ci.org/abrigham1/abrigham.svg?branch=master)](https://travis-ci.org/abrigham1/abrigham)

This is the codebase that powers abrigham.com

## Table of Contents
* [Installation](#installation)

## Installation
To run this you must first have composer, php, nodejs/npm, docker.

Download or clone the repo, once done navigate to the main directory in the command line and run the following commands.
```bash
# copy env files and nginx confs
./first_install.sh

# switch to laradock directory
cd laradock

# bring up our docker containers
docker-compose up -d nginx

# install composer dependencies, npm dependencies, compile assets, generate encryption key
docker-compose exec workspace bash -c "composer install -n && npm install && npm run dev && php artisan key:generate --ansi"
```

Once docker has booted you should be able to access it locally by navigating to abrigham.localhost