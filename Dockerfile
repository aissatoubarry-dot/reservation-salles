FROM php:8.3-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json ./

RUN composer install --no-interaction --prefer-dist --no-progress --optimize-autoloader --no-scripts

COPY . .

EXPOSE 9000

CMD ["php-fpm"]


