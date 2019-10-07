FROM ubuntu:18.04

RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
        curl \
        git-core \
        zip \
        unzip \
        php7.2-common \
        php7.2-cli \
        php7.2-fpm \
        php7.2-mbstring \
        php7.2-xml \
        php7.2-mysql \
        php-xdebug && \
    curl -sSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer && \
    apt-get clean && \
    apt-get --yes --quiet autoremove --purge && \
    rm -rf /tmp/* /var/tmp/* && \
    rm -rf /var/lib/apt/lists/* && \
    mkdir -p /var/run/php

COPY php.ini /etc/php/7.2/fpm/php.ini
COPY xdebug.ini /etc/php/7.2/mods-available
COPY zz-docker.conf /etc/php/7.2/fpm/pool.d/zz-docker.conf

WORKDIR /app
