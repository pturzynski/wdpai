FROM php:8.3-fpm-alpine

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo_pgsql

RUN echo "upload_max_filesize=40M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=50M" >> /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /app
