FROM php:8.3-apache

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite

COPY public/ /var/www/html/

WORKDIR /var/www/html
