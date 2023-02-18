# # FROM php:7.3.17-fpm
# FROM php:7.3-fpm-alpine


# # Install PHP Extensions
# RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

FROM php:7.3.17-apache

WORKDIR /var/www/html

#Install git
RUN apt-get update \
    && apt-get install -y \
    git \
    nano 
RUN docker-php-ext-install pdo pdo_mysql mysqli
# RUN a2enmod rewrite

#Install Composer
# RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# RUN php composer-setup.php --install-dir=. --filename=composer
# RUN mv composer /usr/local/bin/
COPY . .
EXPOSE 80