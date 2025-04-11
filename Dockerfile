FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip unzip curl git netcat-openbsd \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
