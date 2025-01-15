#!/bin/bash

cd /var/www/html/
# Exécuter ton script PHP (par exemple morty.php)
php bin/morty.php -d settings/.env -k your_secret_key -t docker

until nc -zv core_mvc_db 3306; do
  echo "En attente de MariaDB..."
  sleep 1
done
php bin/morty.php -M up
php bin/morty.php -S up

chmod -R 755 /var/www/html
chown -R www-data:www-data /var/www/html

# Démarrer Apache en avant-plan (par défaut pour garder le conteneur en vie)
apache2-foreground
