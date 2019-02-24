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

# bring up our docker containers
docker-compose up -d nginx

# generate our encryption key, install composer dependencies, npm dependencies, and compile webpack assets from within workspace container
docker-compose exec workspace bash -c "php artisan key:generate --ansi && composer install -n && && yarn install && npm run dev"
```

While that is running modify your hosts file adding the proper ipaddress and hostname 
(127.0.0.1 abrigham.localhost).

Once docker has booted you should be able to access it locally by navigating to abrigham.localhost