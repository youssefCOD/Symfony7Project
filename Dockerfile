FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    wget \
    gnupg \
    nodejs \
    npm

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_pgsql \
    intl \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www

# Create a non-root user with same UID/GID as the host user
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Copy project files
COPY --chown=www-data:www-data . .

# Switch to www-data user for subsequent operations
USER www-data

# Create directories with correct permissions
RUN mkdir -p var/cache var/log public/build

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Build assets with Webpack Encore
RUN npm install
RUN npm run build

# Switch back to root for Apache configuration
USER root

# Configure Apache DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Apache configuration file
RUN echo '<Directory ${APACHE_DOCUMENT_ROOT}>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/symfony.conf
RUN a2enconf symfony

# Ensure proper permissions for the entire application
RUN chown -R www-data:www-data /var/www
RUN find /var/www -type f -exec chmod 644 {} \;
RUN find /var/www -type d -exec chmod 755 {} \;
RUN chmod -R 777 /var/www/var

# Start script
COPY --chown=www-data:www-data docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]