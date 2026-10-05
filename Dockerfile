FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones de PHP necesarias (incluyendo SQLite)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Habilitar mod_rewrite de Apache para las rutas de Laravel
RUN a2enmod rewrite

# Instalar Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar todo el proyecto al contenedor
COPY . /var/www/html

# Instalar las dependencias de Composer directamente en el servidor de Render
RUN composer install --no-dev --optimize-autoloader

# Crear la base de datos SQLite y configurar permisos
RUN mkdir -p /var/www/html/database && touch /var/www/html/database/database.sqlite && chmod -R 777 /var/www/html/database

# Configurar el DocumentRoot de Apache para que apunte a la carpeta public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Dar permisos correctos a las carpetas de almacenamiento y caché
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Puerto por el que escucha Render
EXPOSE 80