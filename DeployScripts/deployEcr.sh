#!/usr/bin/env bash

# ecr repo url
ecrRepoUrl="620139381534.dkr.ecr.us-east-1.amazonaws.com/"

# switch to laradock directory to  build docker images
cd `dirname "$(readlink -f "$0")"`/../laradock

# build our containers
docker-compose build nginx php-fpm anaconda

# tag docker images
docker tag laradock_nginx:latest ${ecrRepoUrl}abrigham/nginx:latest
docker tag laradock_php-fpm:latest ${ecrRepoUrl}abrigham/php-fpm:latest
docker tag laradock_anaconda:latest ${ecrRepoUrl}abrigham/anaconda:latest

# run docker login command for ecr
eval $(aws ecr get-login --no-include-email)

# push docker images to ecr
docker push ${ecrRepoUrl}abrigham/nginx:latest
docker push ${ecrRepoUrl}abrigham/php-fpm:latest
docker push ${ecrRepoUrl}abrigham/anaconda:latest

