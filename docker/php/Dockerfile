FROM php:8.4-fpm

ENV TZ=Asia/Jakarta

RUN apt-get update && apt-get install -y \
    git \
    curl \
    nano \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        intl \
        zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN groupadd -g 1000 laravel \
    && useradd -u 1000 -g laravel -m laravel

RUN mkdir -p /tmp \
    && chmod 1777 /tmp

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone

WORKDIR /var/www/html

CMD ["php-fpm"]