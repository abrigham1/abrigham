#abrigham.com
[![Build Status](https://travis-ci.org/abrigham1/abrigham.svg?branch=master)](https://travis-ci.org/abrigham1/abrigham)
[![Coverage Status](https://coveralls.io/repos/github/abrigham1/abrigham/badge.svg?branch=master)](https://coveralls.io/github/abrigham1/abrigham?branch=master)

This is the codebase that powers abrigham.com

##Table of Contents
* [Installation](#installation)
* [Useful Commands](#useful-commands)

##Installation
To run this you must first have git and docker installed.

Clone the repo including the laradock submodule
```bash
git clone --recursive git@github.com:abrigham1/abrigham.git
```

Update your hosts file with the following entry
```bash
127.0.0.1 abrigham.test mlapi.abrigham.test
```

Once done navigate to the main directory in the command line and run the following commands.
```bash
# copy env files
make first/install

# bring up our docker containers
make docker-up

# install composer dependencies, npm dependencies, compile assets, generate encryption key
make local/dist
bin/dev/php artisan key:generate --ansi
```

Once docker has booted you should be able to access it locally by navigating to abrigham.test

##Useful Commands

```bash
### Interacting with docker ###

# bring docker containers up
make docker-up

# bring docker containers down
make docker-down

# restart the containers
make docker-restart

# check the running containers
make docker-ps

# build the containers
make docker-build

# rebuild the containers and bring them back up
make docker-rebuild

# enter the workspace container
make workspace

### portal to run composer/php/npm commands in workspace container ###
bin/dev/composer
bin/dev/php
bin/dev/npm

# examples
bin/dev/php artisan test # docker-compose --env-file laradock/.env -f laradock/docker-compose.yml exec --user=laradock workspace php artisan test
bin/dev/npm install # docker-compose --env-file laradock/.env -f laradock/docker-compose.yml exec --user=laradock workspace bash -c "npm install"
bin/dev/composer update # docker-compose --env-file laradock/.env -f laradock/docker-compose.yml exec --user=laradock workspace bash -c "composer update"
```
