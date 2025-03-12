#!/bin/bash

cd /var/www/html/
# Exécuter ton script PHP (par exemple morty.php)
php bin/morty.php -d settings/.env -k your_secret_key -t docker

until nc -zv core_mvc_db 3306; do
  echo "En attente de MariaDB..."
  sleep 1
done

php bin/morty.php -M up
if [ $? -ne 0 ]; then
    echo "❌ La migration a échoué. Arrêt du conteneur."
    exit 1
fi

php bin/morty.php -S up
if [ $? -ne 0 ]; then
    echo "❌ L'injection des graines a échoué. Arrêt du conteneur."
    exit 1
fi

php bin/tests.php
if [ $? -ne 0 ]; then
    echo "❌ Les tests unitaires ont échoué. Arrêt du conteneur."
    exit 1
fi

chmod -R 755 /var/www/html
chown -R www-data:www-data /var/www/html

# Démarrer Apache en avant-plan (par défaut pour garder le conteneur en vie)
apache2-foreground
