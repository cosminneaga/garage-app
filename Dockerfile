FROM php:7.2-apache

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y \
    git \
    nano

RUN docker-php-ext-install pdo pdo_mysql mysqli sockets
RUN docker-php-ext-enable mysqli

COPY . .
EXPOSE 80