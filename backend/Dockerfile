# ================================
# Base image
# ================================
FROM php:8.2-fpm

# ================================
# Install system dependencies
# ================================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ================================
# Install Composer
# ================================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ================================
# Set working directory
# ================================
WORKDIR /var/www/vijaykumardvk

# ================================
# Copy composer files first (for layer caching)
# ================================
COPY composer.json composer.lock ./

# ================================
# Install PHP dependencies
# ================================
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ================================
# Copy remaining application files
# ================================
COPY . .

# ================================
# Fix permissions
# ================================
RUN chown -R www-data:www-data /var/www/vijaykumardvk \
    && chmod -R 775 storage bootstrap/cache

# ================================
# Expose port
# ================================
EXPOSE 9000

# ================================
# Start PHP-FPM
# ================================
CMD ["php-fpm"]