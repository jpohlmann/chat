FROM php:7.4-fpm
COPY ./.env.example /var/www/.env
COPY ./scripts/initialize.sh /usr/local/bin/
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/local/bin/initialize.sh