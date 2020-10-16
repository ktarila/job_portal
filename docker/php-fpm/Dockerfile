
ARG VERSION

# Dev image
FROM php:${VERSION}-fpm-alpine AS dev

## Install system dependencies
RUN apk update && \
    apk add --no-cache --virtual dev-deps git autoconf gcc g++ make && \
    apk add --no-cache zlib-dev libzip-dev && \
    apk add --no-cache yarn

## Install php extensions
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    pecl install redis apcu apcu_bc && \
    docker-php-ext-enable redis apcu && \
    docker-php-ext-install pdo_mysql zip opcache

## Copy php default configuration
COPY ./docker/php-fpm/default.ini /usr/local/etc/php/conf.d/default.ini


WORKDIR /app

## Install composer
RUN wget https://getcomposer.org/installer && \
    php installer --install-dir=/usr/local/bin/ --filename=composer && \
    rm installer && \
    composer global require hirak/prestissimo

## Copy project files to workdir
# COPY . .
# RUN yarn install && yarn dev --watch


# Test image
FROM dev AS test

WORKDIR /app

## Copy project files to workdir
COPY . .
# RUN ls .

## Install application dependencies
RUN composer install --no-interaction --optimize-autoloader

RUN yarn install && yarn dev --watch

## Change files owner to php-fpm default user
RUN chown -R www-data:www-data .

# Prod image
FROM test AS prod

WORKDIR /app

## Remove dev dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader

## Disable xdebug on production
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#Yarn prdocution
RUN yarn install && yarn encore production

## Cleanup
RUN apk del dev-deps && \
    composer global remove hirak/prestissimo && \
    rm /usr/local/bin/composer