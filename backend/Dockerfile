# ================================
# Base image: PHP 8.3 FPM
# ================================
FROM php:8.3-fpm

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
# Copy application files
# ================================
COPY . /var/www/vijaykumardvk

# ================================
# Fix git ownership issue
# ================================
RUN git config --global --add safe.directory /var/www/vijaykumardvk

# ================================
# Permissions (Laravel required)
# ================================
RUN chown -R www-data:www-data /var/www/vijaykumardvk \
    && chmod -R 775 storage bootstrap/cache

# ================================
# Expose PHP-FPM port
# ================================
EXPOSE 9000

# ================================
# Start PHP-FPM
# ================================
CMD ["php-fpm"]