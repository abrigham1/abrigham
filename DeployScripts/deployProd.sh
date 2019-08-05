#!/bin/bash

# exit if any command fails
set -ev

# initialize the env
eb init abrigham--platform "Multi-container Docker" --region "us-east-1"

# use our elastic beanstalk production environment
eb use abrigham-prod

# deploy the application
eb deploy