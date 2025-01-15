FROM php:8.3-apache

# Installer les dépendances nécessaires, y compris curl
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    netcat-traditional \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Copier la configuration personnalisée
# COPY configs/000-default.conf /etc/apache2/sites-available/000-default.conf

# Activer mod_rewrite pour le routage MVC
RUN a2enmod rewrite

COPY configs/entrypoint.sh /usr/local/bin/entrypoint.sh

COPY src/storage /var/www/html/storage

RUN chmod +x /usr/local/bin/entrypoint.sh

# Définir le script comme point d'entrée
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["apache2-foreground"]
