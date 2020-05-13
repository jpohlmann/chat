FROM php:7.4-fpm
RUN apt-get update &&\
    apt-get upgrade -y&&\
    apt-get install git -y
WORKDIR /var/www/
COPY ./.env.example ./.env

COPY ./scripts/initialize.sh /usr/local/bin/
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY ./composer.json ./composer.lock* ./
ENV COMPOSER_VENDOR_DIR=/var/www/vendor

RUN composer install --no-scripts --no-autoloader --ansi --no-interaction
RUN composer dump-autoload -o

RUN chmod +x /usr/local/bin/initialize.sh