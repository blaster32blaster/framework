FROM php:7.2.2-apache

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
# Tools
    apt-utils \
    wget \
    git \
    nano \
    iputils-ping \
    locales \
    unzip \
    zip \
    xz-utils \
    vim \
    libaio1 \
    libaio-dev \
    build-essential \
    libzip-dev \
    libxml2-dev \
    libmcrypt-dev \
    libpng-dev \
    default-mysql-client \
    nodejs && apt-get clean autoclean && apt-get autoremove --yes &&  rm -rf /var/lib/{apt,dpkg,cache,log}/

RUN docker-php-ext-configure gd && \
    docker-php-ext-install -j$(nproc) mysqli soap gd zip opcache pdo pdo_mysql
