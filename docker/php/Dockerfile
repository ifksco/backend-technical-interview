FROM php:8.2.6-fpm as php_base

WORKDIR /var/www/html

# Install base software
RUN apt-get update \
    && apt-get install -y \
        zsh \
        git \
        curl \
        zip \
        unzip \
        wget \
        libzip-dev \
        libpng-dev \
        libmagickwand-dev \
        libcurl4-openssl-dev \
        pkg-config \
        libssl-dev

# Install base php extensions
RUN pecl install \
        redis \
        xdebug \
        imagick \
        zstd \
        mongodb \
        zip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install \
        gd \
        pdo \
        pdo_mysql \
        bcmath \
        exif \
        sockets \
        pcntl

# Enable base php extensions
RUN docker-php-ext-enable \
        redis \
        xdebug \
        imagick \
        zstd \
        mongodb \
        bcmath \
        exif \
        sockets \
        zip \
        pcntl

# Install workdir rules
RUN chown -R www-data:www-data /var/www/

# Install FPM default port number
EXPOSE 9000

FROM php_base as php_app
# Install composer
RUN curl -sS https://getcomposer.org/installer  \
    | php -- --install-dir=/usr/local/bin --filename=composer

# Container user & group
ARG USER_ID
ARG GROUP_ID

# Check if user and group doesn't exist before creating
RUN getent group "$GROUP_ID" || addgroup --gid "$GROUP_ID" user
RUN getent passwd "$USER_ID" || adduser --disabled-password --gecos '' --uid "$USER_ID" --gid "$GROUP_ID" user

USER "$USER_ID"

FROM php_base as php_supervisor

# Install supervisor
RUN apt-get update && apt-get install -y supervisor

# Container user & group
ARG USER_ID
ARG GROUP_ID

# Check if user and group doesn't exist before creating
RUN getent group "$GROUP_ID" || addgroup --gid "$GROUP_ID" user
RUN getent passwd "$USER_ID" || adduser --disabled-password --gecos '' --uid "$USER_ID" --gid "$GROUP_ID" user

RUN chmod 777 -R /var/log/supervisor

USER "$USER_ID"
