# Stage 1: Build stage for PHP extensions (optional)
FROM php:8.2-apache-bullseye AS build

# Install dependencies needed for PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apt-get purge -y --auto-remove unzip \
    && rm -rf /var/lib/apt/lists/*

# Stage 2: Production image
FROM php:8.2-apache-bullseye

# Copy PHP extensions from build stage
COPY --from=build /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=build /usr/local/etc/php/ /usr/local/etc/php/

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy application files
COPY . /var/www/html/

# Set working directory and fix permissions
WORKDIR /var/www/html/
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose Apache port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
