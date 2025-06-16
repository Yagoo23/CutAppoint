FROM php:8.1-cli

# Instala extensiones necesarias y utilidades
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git \
    && docker-php-ext-install zip mysqli

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia el código fuente al contenedor
WORKDIR /app
COPY . /app

# Instala dependencias de Composer
RUN composer install

# Expone el puerto 3000
EXPOSE 3000

# Comando por defecto para iniciar el servidor PHP
CMD ["php", "-S", "0.0.0.0:3000", "-t", "public"]