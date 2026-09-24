FROM php:8.4-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install \
        pdo_pgsql \
        mbstring \
        zip \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node.js
COPY --from=node:22 /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22 /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# Dépendances PHP
COPY composer.json composer.lock ./

RUN composer install \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --no-scripts

# Dépendances JavaScript
COPY package.json package-lock.json* ./

RUN npm install

# Application
COPY . .

# Assets Vite
RUN npm run build

# Autoload Laravel
RUN composer dump-autoload --optimize

# Port Render
EXPOSE 8000

# Migrations + serveur Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
