# Dockerfile
FROM php:8.0-apache

RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite
RUN composer install

ADD . /var/www
ADD ./public /var/www/html