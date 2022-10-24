# This Dockerfile will install
# imagemagic, xdebug, vim
FROM php:5.3.29-apache

ENV PHP_IDE_CONFIG="serverName=docker-server"

COPY docker/php/php.ini /usr/local/lib/

RUN apt-get update
RUN apt-get install -y --force-yes vim

# xdebug for php 5.3
RUN pecl install xdebug-2.2.7

# install imagemagic and imagick for php
RUN apt-get install -y --force-yes imagemagick
RUN pecl install imagick-3.3.0
RUN printf "\nextension=/usr/local/lib/php/extensions/no-debug-non-zts-20090626/imagick.so" >> /usr/local/lib/php.ini

WORKDIR /var/www/html
