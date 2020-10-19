
ARG VERSION

# Dev image
FROM php:${VERSION}-fpm-alpine AS dev

## Install system dependencies
RUN apk update && \
    apk add --no-cache --virtual dev-deps git autoconf gcc g++ make && \
    apk add --no-cache zlib-dev libzip-dev

## Install php extensions
RUN docker-php-ext-install pdo_mysql zip

## Copy php default configuration
COPY ./docker/php-fpm/default.ini /usr/local/etc/php/conf.d/default.ini

## Copy shell messenger script 
COPY ./docker/php-fpm-consume-msg/message_script.sh /var/www/scripts/

WORKDIR /app

## Install composer
RUN wget https://getcomposer.org/installer && \
    php installer --install-dir=/usr/local/bin/ --filename=composer && \
    rm installer && \
    composer global require hirak/prestissimo

ENTRYPOINT ["sh", "/var/www/scripts/message_script.sh"]


# Test image
FROM dev AS test

WORKDIR /app

## Copy project files to workdir
COPY . .
# RUN ls .

## Install application dependencies
RUN composer install --no-interaction --optimize-autoloader


## Change files owner to php-fpm default user
RUN chown -R www-data:www-data .

# Prod image
FROM test AS prod

WORKDIR /app

## Remove dev dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader


## Cleanup
RUN apk del dev-deps && \
    composer global remove hirak/prestissimo && \
    rm /usr/local/bin/composer