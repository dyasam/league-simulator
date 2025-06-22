FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev libonig-dev libxml2-dev \
    libsqlite3-dev sqlite3 gnupg \
    && docker-php-ext-install pdo_mysql pdo_sqlite zip bcmath pcntl sockets

RUN pecl install redis && docker-php-ext-enable redis

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    npm install --global yarn

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
