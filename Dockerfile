FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install

RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000

CMD ["php-fpm"]