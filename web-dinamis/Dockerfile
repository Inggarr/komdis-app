FROM php:8.2-apache

# Install ekstensi mysqli dan pdo_mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy semua file ke dalam web root Apache
COPY . /var/www/html/

# Buat folder upload dan set permission agar bisa ditulis oleh Apache
RUN mkdir -p /var/www/html/assets/upload/berita \
    && mkdir -p /var/www/html/assets/upload/profil \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/assets/upload

EXPOSE 80
