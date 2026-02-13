FROM php:8.4-fpm-alpine

ARG TIMEZONE=Europe/Paris

RUN apk add --no-cache \
    bash \
    git \
    unzip \
    curl \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    postgresql-dev \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    intl \
    zip \
    opcache \
    gd \
    mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini

RUN echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

WORKDIR /var/www/symfony

# Copier tout le projet
COPY . .

# Installation des dépendances PHP
RUN composer install --optimize-autoloader --no-interaction

RUN php bin/console tailwind:build

RUN chown -R www-data:www-data /var/www/symfony

# Script d'entrypoint pour initialiser les volumes nommés
RUN printf '#!/bin/sh\n\
if [ ! -f /var/www/symfony/vendor/autoload.php ]; then\n\
    composer install --optimize-autoloader --no-interaction\n\
fi\n\
if [ ! -d /var/www/symfony/var/cache ]; then\n\
    php bin/console cache:warmup\n\
fi\n\
chown -R www-data:www-data /var/www/symfony/vendor /var/www/symfony/var\n\
exec "$@"\n' > /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]

# Exposer le port
EXPOSE 9000

CMD ["php-fpm"]
