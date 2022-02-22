#!/bin/bash
set -e

echo "Deployment started ..."

git remote set-url git@github.com:hong195/guru-server.git

. ~/.nvm/nvm.sh
#php='/opt/php80/bin/php'
php='php'
# Enter maintenance mode or return true
# if already is in maintenance mode
$php -v
($php artisan down) || true


# Pull the latest version of the app
git pull origin master

# Install composer dependencies
$php ./composer.phar install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache
$php artisan clear-compiled

# Recreate cache
$php artisan optimize

# Compile npm assets
nvm use 12

npm install && npm run prod

# Run database migrations
$php artisan migrate --force

# Exit maintenance mode
$php artisan up

echo "Deployment finished!"
