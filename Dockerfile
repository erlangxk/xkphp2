FROM php:8.4-cli-alpine

# Install required system dependencies
RUN apk add --no-cache $PHPIZE_DEPS git libzip-dev zip unzip oniguruma-dev \
    && docker-php-ext-install \
        pcntl \
        zip \
        mbstring \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/app

# Copy composer files and install dependencies
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-scripts --no-autoloader

# Copy project files
COPY . .

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Expose port
EXPOSE 1337

# Set up entrypoint
CMD ["php", "index.php"]