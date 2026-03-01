FROM composer:latest AS composer

FROM php:8.4-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    linux-headers-generic || true \
    && docker-php-ext-install pcntl \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app
