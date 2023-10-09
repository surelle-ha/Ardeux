# Use an official PHP image with PHP 8.1 as the base image
FROM php:8.1-fpm

# Install system dependencies and PHP extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Set the working directory to /app
WORKDIR /app/ardeux_main

# Copy the rest of the application code
COPY ardeux_main/ .


COPY ardeux_main/.env.docker .env

# Install Composer and run composer install (if needed)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

# Expose port 8000 for Laravel app
EXPOSE 8000

# Generate the application key (you can do this as part of your Docker build)
RUN php artisan key:generate

# Define the command to run the Laravel app
CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]
