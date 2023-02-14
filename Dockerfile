# Dockerfile
FROM php:8.0-apache

RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pwd

ADD . /var/www
ADD ./public /var/www/html
