FROM php:8.2.13-apache

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli \
    && docker-php-ext-install pdo_mysql

COPY --from=composer:2.6.5 /usr/bin/composer /usr/local/bin/composer

RUN a2enmod rewrite
