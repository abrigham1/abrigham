#######################################################
### Setup

.PHONY: first/install
first/install:
	cp -n .env.example .env
	cp -n laradock/.env.example laradock/.env

#######################################################
### Local

.PHONY: local/dist
local/dist: node_modules vendor local/npm-run

vendor: composer.json composer.lock
	bin/dev/composer install --prefer-dist

node_modules: package.json package-lock.json
	bin/dev/npm install

.PHONY: local/npm-run
local/npm-run:
	bin/dev/npm run dev

#######################################################
### CI

.PHONY: ci/dist
ci/dist: ci/vendor ci/generate-key ci/node_modules ci/npm-run

.PHONY: ci/vendor
ci/vendor:
	bin/dev/composer install --optimize-autoloader --no-suggest --no-interaction --prefer-dist

.PHONY: ci/generate-key
ci/generate-key:
	bin/dev/php artisan key:generate --ansi

.PHONY: ci/npm-run
ci/npm-run:
	bin/dev/npm run dev

.PHONY: ci/node_modules
ci/node_modules:
	bin/dev/npm install--unsafe-perm

########################################################
### Prod

.PHONY: prod/dist
prod/dist: prod/vendor prod/node_modules prod/npm-run prod/clear-cached

.PHONY: prod/vendor
prod/vendor:
	bin/dev/composer install --no-dev --optimize-autoloader --no-interaction --no-suggest --prefer-dist

.PHONY: prod/npm-run
prod/npm-run:
	bin/dev/npm run prod

.PHONY: prod/node_modules
prod/node_modules:
	bin/dev/npm install--unsafe-perm

.PHONY: prod/clear-cached
prod/clear-cached:
	bin/dev/php artisan clear-compiled
	bin/dev/php artisan route:clear
	bin/dev/php artisan cache:clear
	bin/dev/php artisan view:clear
	bin/dev/php artisan route:cache

########################################################
### Docker

.PHONY: docker-up
docker-up:
	docker-compose -f laradock/docker-compose.yml --project-directory laradock up -d

.PHONY: docker-down
docker-down:
	docker-compose -f laradock/docker-compose.yml --project-directory laradock down

.PHONY: docker-ps
docker-ps:
	docker-compose -f laradock/docker-compose.yml --project-directory laradock ps

.PHONY: docker-restart
docker-restart:
	docker-compose -f laradock/docker-compose.yml --project-directory laradock restart

.PHONY: docker-build
docker-build:
	docker-compose -f laradock/docker-compose.yml --project-directory laradock build

.PHONY: docker-rebuild
docker-rebuild: docker-down docker-build docker-up

.PHONY: workspace
workspace:
	docker-compose -f laradock/docker-compose.yml --project-directory laradock exec --user=laradock workspace bash
