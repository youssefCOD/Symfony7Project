#!/bin/bash


# Clear and warmup cache
php bin/console cache:clear
php bin/console cache:warmup

# Run migrations if they exist
if [ -f ./migrations ]; then
    php bin/console doctrine:migrations:migrate --no-interaction
fi

# Install assets
php bin/console assets:install

# Start Apache
exec "$@"