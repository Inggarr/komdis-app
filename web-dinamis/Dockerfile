FROM php:8.2-apache

# Install ekstensi mysqli dan pdo_mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy semua file ke dalam web root Apache
COPY . /var/www/html/

# Set permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80
