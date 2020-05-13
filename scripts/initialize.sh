#!/bin/sh
set -e
touch /var/www/database/database.sqlite
test -f ./.env || cp ./.env.example ./.env

php artisan migrate --force

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"