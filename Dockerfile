FROM php:8.2-apache
LABEL authors="Jacob Chestnut"

# Install additional PHP extensions if needed
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy your PHP application to the web directory
COPY ./src /var/www/html/

# Set permissions if necessary
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
CMD ["apache2-foreground"]