FROM ubuntu:22.04

# Prevenir prompts interactivos
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

# 1. Instalar dependencias del sistema 
RUN apt-get update && apt-get install -y \
    git \
    sudo \
    openssh-client \
    libxml2-dev \
    autoconf \
    gcc \
    g++ \
    make \
    npm \
    libfreetype6-dev \
    libjpeg-turbo8-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    curl \
    wget \
    software-properties-common \
    && rm -rf /var/lib/apt/lists/*

# 2. Instalar PHP 8.2 y extensiones esenciales
RUN add-apt-repository ppa:ondrej/php -y \
    && apt-get update \
    && apt-get install -y \
        php8.2-cli \
        php8.2-common \
        php8.2-mbstring \
        php8.2-xml \
        php8.2-gd \
        php8.2-zip \
        php8.2-pdo \
        php8.2-mysql \
        php8.2-bcmath \
        php8.2-soap \
        php8.2-intl \
        php8.2-curl \
        php8.2-dev \
        php-pear \
    && rm -rf /var/lib/apt/lists/*

# 3. Instalar extensiones PECL (Swoole y PCOV solamente)
RUN pecl channel-update pecl.php.net \
    && pecl install pcov swoole \
    && echo "extension=pcov.so" > /etc/php/8.2/mods-available/pcov.ini \
    && echo "extension=swoole.so" > /etc/php/8.2/mods-available/swoole.ini \
    && phpenmod pcov swoole

# 4. Traer Composer y RoadRunner
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=ghcr.io/roadrunner-server/roadrunner:latest /usr/bin/rr /usr/local/bin/rr

WORKDIR /app

# 5. Copiar archivos y preparar Laravel
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-interaction --optimize-autoloader
RUN composer require laravel/octane spiral/roadrunner --no-interaction

# 6. Configuración de Octane
RUN php artisan octane:install --server="swoole" --no-interaction

# 7. Permisos
RUN mkdir -p storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000"]