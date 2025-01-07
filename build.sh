#!/bin/bash

# Install dependencies
composer install

# Clear cache
php bin/console cache:clear
php bin/console cache:warmup

# Install assets
php bin/console assets:install