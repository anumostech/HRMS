FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && \
    apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    netcat-openbsd \
    libgd-dev && \
    rm -rf /var/lib/apt/lists/*

# Generate locales
RUN locale-gen en_US.UTF-8

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_mysql mbstring zip exif pcntl mysqli gd

# Set working directory
WORKDIR /var/www/html

# Copy composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Remove storage symlink if exists (Fix for Docker build issue)
RUN rm -rf public/storage

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set correct permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Create storage symlink inside container
RUN php artisan storage:link || true

# Expose port
EXPOSE 9000

CMD ["php-fpm"]