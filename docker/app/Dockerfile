FROM php:7.3.17-fpm-alpine

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    mariadb-client                       \
    zip                                  \
    unzip                                \
    xauth                                \
    xvfb                                 \
    curl                              && \
                                         \
    apt-get clean                     && \
    rm -rf /var/lib/apt/lists/*

# Install nodejs
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install nodejs -y

# Install PHP Extensions
RUN docker-php-ext-install \
    pdo                    \
    pdo_mysql              \
    mysqli

# Copy existing application directory contents
COPY ../../ /var/www