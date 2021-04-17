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
