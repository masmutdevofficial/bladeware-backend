# Base image dengan PHP 8.3 + NGINX Unit
FROM unit:1.34.1-php8.3

# Install library yang umum dipakai Laravel
RUN apt update && apt install -y \
    curl wget unzip git libicu-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pcntl opcache pdo pdo_mysql intl zip gd exif ftp bcmath \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

# Custom PHP config
RUN echo "opcache.enable=1" > /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.jit=tracing" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.jit_buffer_size=256M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "memory_limit=512M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "upload_max_filesize=64M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size=64M" >> /usr/local/etc/php/conf.d/custom.ini

# Tambah composer (copy dari official image)
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

# Buat folder storage & cache Laravel
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R unit:unit /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy source code Laravel
COPY . .

# Fix permission & deploy.sh
RUN chown -R unit:unit storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && if [ -f deploy.sh ]; then sed -i 's/\r$//' deploy.sh && chmod +x deploy.sh; fi

# Install dependencies (prod only, lebih ringan)
RUN composer install --prefer-dist --optimize-autoloader --no-dev --no-interaction

# Copy konfigurasi Unit (reverse proxy + PHP handler)
COPY unit.json /docker-entrypoint.d/unit.json

EXPOSE 8000

CMD ["unitd", "--no-daemon"]
