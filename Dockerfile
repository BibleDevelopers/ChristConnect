# Multi-stage Dockerfile for production

### Node build stage (build frontend assets)
FROM node:18-alpine AS node-build
WORKDIR /app
COPY package*.json ./
RUN npm ci --silent
COPY vite.config.js .
COPY resources resources
COPY public public
RUN npm run build

### PHP / Composer stage
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copy application files
COPY . /var/www

# Copy built assets from node stage
COPY --from=node-build /app/public /var/www/public

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache || true
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache || true

EXPOSE 9000

CMD ["php-fpm"]
