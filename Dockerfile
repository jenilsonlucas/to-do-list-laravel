FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libonig-dev \        
    libzip-dev \        
    zip \
    unzip \
    curl \
    git \
    libpq-dev \
    nginx \
    gettext-base \
 && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd \
 && mkdir -p /etc/nginx/conf.d


# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar código
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Copiar entrypoint e template
COPY ./docker/entrypoint.sh /app/docker/entrypoint.sh
COPY ./docker/nginx/renderTemplate/nginx.conf.template /app/docker/nginx/renderTemplate/nginx.conf.template

RUN chmod +x ./docker/entrypoint.sh


ENTRYPOINT ["./docker/entrypoint.sh"]