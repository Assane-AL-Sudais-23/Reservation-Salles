FROM php:8.2-fpm

# Installation des dépendances système et des extensions PHP nécessaires (PDO MySQL)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql
    
# Récupération de l'exécutable Composer depuis l'image officielle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www