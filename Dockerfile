# ─── Stage 1 : build des assets JS/CSS ───────────────────────────────────────
FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json ./
RUN npm install

COPY . .
RUN npm run build


# ─── Stage 2 : image de production ───────────────────────────────────────────
FROM php:8.2-fpm-alpine AS production

# Dépendances systèmes
RUN apk add --no-cache \
    bash \
    curl \
    nginx \
    supervisor \
    git \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    mysql-client

# Extensions PHP
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Dépendances PHP (couche cachée)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Code de l'application
COPY . .

# Assets buildés depuis le stage 1
COPY --from=assets /app/public/build ./public/build

# Optimisations Laravel
RUN composer dump-autoload --optimize --classmap-authoritative

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Logs supervisor
RUN mkdir -p /var/log/supervisor

# Configs
COPY docker/nginx/nginx.conf      /etc/nginx/nginx.conf
COPY docker/php/php.ini           /usr/local/etc/php/conf.d/app.ini
COPY docker/supervisord.conf      /etc/supervisord.conf
COPY docker/entrypoint.sh         /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
