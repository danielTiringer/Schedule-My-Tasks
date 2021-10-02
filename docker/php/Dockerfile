ARG PHP_VERSION
FROM php:${PHP_VERSION}-apache as base

RUN apt update && apt install -y unzip libzip-dev libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install zip intl mysqli \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite
RUN a2enmod actions
COPY apache2.conf /etc/apache2/
RUN service apache2 restart

FROM base as dev

# CodeIgniter requires the PHP additions to be in place, even when creating a project
RUN curl --fail --silent --show-error --location https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ARG PUID=1000
RUN useradd -G www-data,root -u $PUID -d /home/devuser devuser
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser
