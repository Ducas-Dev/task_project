# ==========================================================
# STAGE 1 — Build des assets Vite
# ==========================================================

FROM node:20-alpine AS frontend

WORKDIR /app

# Copier uniquement les fichiers npm
COPY package.json package-lock.json ./

# Installer les dépendances JavaScript
RUN npm ci

# Copier les fichiers nécessaires à Vite
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

# Si tu as une configuration Vite supplémentaire,
# elle peut être copiée ici également.
# COPY postcss.config.js ./

# Construire les assets
RUN npm run build


# ==========================================================
# STAGE 2 — Application Laravel
# ==========================================================

FROM php:8.4-fpm

WORKDIR /var/www/html


# ==========================================================
# Arguments / variables
# ==========================================================

ARG APP_ENV=production


# ==========================================================
# Dépendances système
# ==========================================================

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        pgsql \
        mbstring \
        bcmath \
        intl \
        zip \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# ==========================================================
# Composer
# ==========================================================

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# ==========================================================
# Copier le projet Laravel
# ==========================================================

COPY . .


# ==========================================================
# Installer les dépendances Laravel
# ==========================================================

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader


# ==========================================================
# Copier les assets générés par Vite
# ==========================================================

COPY --from=frontend /app/public/build ./public/build


# ==========================================================
# Configuration PHP
# ==========================================================

RUN docker-php-ext-enable \
    pdo_pgsql \
    pgsql \
    opcache


# ==========================================================
# Permissions Laravel
# ==========================================================

RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache \
    public


RUN chmod -R 775 \
    storage \
    bootstrap/cache


# ==========================================================
# OPcache
# ==========================================================

RUN { \
        echo 'opcache.enable=1'; \
        echo 'opcache.enable_cli=1'; \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=10000'; \
        echo 'opcache.validate_timestamps=0'; \
    } > /usr/local/etc/php/conf.d/opcache.ini


# ==========================================================
# Port PHP-FPM
# ==========================================================

EXPOSE 9000


# ==========================================================
# Démarrage
# ==========================================================

CMD ["php-fpm"]
