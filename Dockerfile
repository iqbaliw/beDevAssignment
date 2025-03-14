# Use the base image
FROM docker.io/library/be-base

# Set the working directory
WORKDIR /var/www/html

# Copy Laravel application files
COPY --chown=www-data:www-data . .

# Install Composer dependencies
RUN apk --no-cache add \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        && docker-php-ext-configure gd --with-freetype \
        && docker-php-ext-install gd pdo pdo_mysql opcache \
        && docker-php-ext-enable pdo_mysql

# Install additional required PHP extensions for Laravel
RUN docker-php-ext-install bcmath \
    && docker-php-ext-enable bcmath

# Set permissions
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose the application port
EXPOSE 80

# Start Supervisor, Nginx, and PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]