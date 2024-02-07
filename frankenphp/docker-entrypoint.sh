#!/bin/sh
set -e

if [ "$1" = 'frankenphp' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/console' ]; then

	if [ -d "vendor/" ]; then
    echo "Composer dependencies already installed. Updating..."
    composer update --prefer-dist --no-progress --no-interaction
  else
    echo "Composer dependencies not found. Installing..."
		composer install --prefer-dist --no-progress --no-interaction
  fi

  if [ ! -d "node_modules/" ]; then
    echo "Installing npm dependencies..."
    npm install
    echo "Compiling assets..."
    npm run dev
  else
    if [ ! -d "public/build/" ]; then
      echo "Compiling assets..."
      npm run dev
    fi
  fi

  php bin/console doctrine:schema:update -f

  echo "Setting permissions..."
	setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var
	setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var
fi

exec docker-php-entrypoint "$@"