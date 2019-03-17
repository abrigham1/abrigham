#!/usr/bin/env bash

# exit if any command fails
set -e

# switch to deploy scripts dir
cd `dirname "$(readlink -f "$0")"`

# put the app in production mode
./enterProductionMode.sh

# switch to base dir
cd `dirname "$(readlink -f "$0")"`/../

# deploy to elastic beanstalk
eb deploy

#switch to deploy scripts dir
cd `dirname "$(readlink -f "$0")"`

# put the app in dev mode
./enterDevMode.sh