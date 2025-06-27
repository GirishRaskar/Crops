# Start from official PHP with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev libonig-dev libxml2-dev libicu-dev \
    && docker-php-ext-install zip mysqli pdo pdo_mysql intl

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application code into container
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose HTTP port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
