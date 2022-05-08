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
### Docker

.PHONY: docker-up
docker-up:
	cd laradock && docker-compose up -d && cd ../

.PHONY: docker-down
docker-down:
	cd laradock && docker-compose down && cd ../

.PHONY: docker-ps
docker-ps:
	cd laradock && docker-compose ps && cd ../

.PHONY: docker-restart
docker-restart:
	cd laradock &&docker-compose restart && cd ../

.PHONY: docker-build
docker-build:
	cd laradock &&docker-compose build && cd ../

.PHONY: docker-build-no-cache
docker-build-no-cache:
	cd laradock && docker-compose build --no-cache && cd ../

.PHONY: docker-rebuild
docker-rebuild: docker-down docker-build docker-up

.PHONY: docker-rebuild-no-cache
docker-rebuild-no-cache: docker-down docker-build-no-cache docker-up

.PHONY: workspace
workspace:
	docker-compose -f laradock/docker-compose.yml --project-directory laradock exec --user=laradock workspace bash
