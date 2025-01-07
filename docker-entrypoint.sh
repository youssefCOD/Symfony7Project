#!/bin/bash

set -e  # Exit immediately if a command exits with a non-zero status

echo "Starting Docker Entrypoint Script..."

# Ensure proper permissions before anything else
echo "Fixing permissions for cache, logs, and other runtime directories..."
mkdir -p /var/www/var/cache /var/www/var/log /var/www/public/build
chmod -R 775 /var/www/var /var/www/public/build
chown -R www-data:www-data /var/www/var /var/www/public/build

# Clear and warmup Symfony cache
echo "Clearing and warming up Symfony cache..."
php bin/console cache:clear --env=prod --no-debug
php bin/console cache:warmup --env=prod --no-debug

# Run database migrations (if migrations directory exists and has content)
if [ -d ./migrations ] && [ "$(ls -A ./migrations)" ]; then
    echo "Running database migrations..."
    php bin/console doctrine:migrations:migrate --no-interaction --env=prod
else
    echo "No migrations to run."
fi

# Install assets
echo "Installing assets..."
php bin/console assets:install --symlink --relative

# Fix permissions for cache and logs again (just in case)
echo "Fixing permissions after cache and assets setup..."
chmod -R 775 /var/www/var /var/www/public/build
chown -R www-data:www-data /var/www/var /var/www/public/build

# Output environment info for debugging
echo "Environment Variables:"
printenv | grep -E 'DATABASE_URL|APP_ENV|APP_DEBUG|SYMFONY|NODE|NPM'

# Start Apache
echo "Starting Apache..."
exec "$@"
