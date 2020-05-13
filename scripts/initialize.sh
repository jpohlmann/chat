#!/bin/sh
set -e
touch /var/www/database/database.sqlite
composer install --no-scripts --no-autoloader --ansi --no-interaction
php artisan migrate

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"