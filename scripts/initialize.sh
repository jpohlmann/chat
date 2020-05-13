#!/bin/sh
set -e
touch /var/www/database/database.sqlite
cd /var/www/
test -f ./.env || cp ./.env.example ./.env

composer install
composer dump-autoload

php artisan migrate --force

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"