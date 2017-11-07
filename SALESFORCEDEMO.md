# Salesforce Demo

A working version of this demo can be seen at: https://www.abrigham.com/salesforce-demo 
if you would like to run it locally follow the instructions below under installation and configuration

## Table of Contents
* [Installation](#installation)
* [Configuration](#configuration)
* [Overview](#overview)


## Installation
To run this you must first have composer, php, nodejs/npm, virtualbox and vagrant.

Download or clone the repo, once done navigate to the main directory in the command line and run the following commands.
```bash
composer install
npm install
npm run dev
```

Next you'll need an environment file so copy .env.example to .env using your preferred method.

This will install all your dependencies and get your assets up to date

Once you've done that you'll want to get a [Laravel Homstead](https://laravel.com/docs/5.4/homestead#per-project-installation) box up and running

To do so run the following command

Mac/Linux:
```bash
php vendor/bin/homestead make
```

Windows:
```bash
vendor\\bin\\homestead make
```

Once you've done that you can check the Homestead.yaml file it created to make sure it looks correct.

Run the following command to bring your new homestead virtual machine up:
```bash
vagrant up
```

While that is running modify your hosts file adding the proper ipaddress and hostname from your 
Homestead.yaml file (192.168.10.10 abrigham.app).

Once homestead has booted you should be able to access it locally by navigating to abrigham.app.

## Configuration

The main configuration file for Salesforce is through abrigham/config/forrest.php. Currently the site is configured
to use the WebServer authentication flow, but with small changes could be updated to use the UserPassword
flow.

The items that need to be filled in with your info are as follows:

* consumerKey (your salesforce consumer key)
* consumerSecret (your salesforce consumer secret)
* callbackURI (your callback uri ex http://abrigham.app/salesforce/oauth2/callback)
* loginURL (your login url ex https://myinstance.salesforce.com)

These can conveniently be filled in within your environment file located at abrigham/.env with the following keys

* SALESFORCE_CONSUMER_KEY
* SALESFORCE_CONSUMER_SECRET
* SALESFORCE_CALLBACK_URI
* SALESFORCE_LOGIN_URL

Once you have added proper config values you can go to /salesforce-demo and it should automatically redirect
you to authenticate if you haven't

## Overview

The configuration for this demo happens in **_[abrigham/.env](https://github.com/abrigham1/abrigham/blob/master/.env.example)_** and **_[abrigham/config/forrest.php](https://github.com/abrigham1/abrigham/blob/master/config/forrest.php)_**

The controller for this demo is **_[abrigham/app/Http/Controllers/SalesforceDemoController.php](https://github.com/abrigham1/abrigham/blob/master/app/Http/Controllers/SalesforceDemoController.php)_**

The model for this demo is **_[abrigham/app/SalesforceContact.php](https://github.com/abrigham1/abrigham/blob/master/app/SalesforceContact.php)_**

The tests for this demo are **_[abrigham/tests/Feature/SalesforceDemoControllerTest.php](https://github.com/abrigham1/abrigham/blob/master/tests/Feature/SalesforceDemoControllerTest.php)_** and **_[abrigham/tests/Unit/SalesforceContactTest.php](https://github.com/abrigham1/abrigham/blob/master/tests/Unit/SalesforceContactTest.php)_**

The routes for this demo happens in **_[abrigham/routes/web.php](https://github.com/abrigham1/abrigham/blob/master/routes/web.php)_**