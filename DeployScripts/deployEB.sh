#!/usr/bin/env bash

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

# put the app in production mode
./enterDevMode.sh

