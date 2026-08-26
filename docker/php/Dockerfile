FROM php:8.4-cli

WORKDIR /var/www/html

# Dépendances système + extensions PHP
RUN apt-get update && apt-get install -y \
    libpq-dev libonig-dev libzip-dev zip unzip curl git \
    && docker-php-ext-install pdo_pgsql  mbstring zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Node.js 22
COPY --from=node:22 /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22 /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# Dépendances PHP
COPY composer.json composer.lock ./


# Application
COPY . .

EXPOSE 8000
EXPOSE 5173

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
