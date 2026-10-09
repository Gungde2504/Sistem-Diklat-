# ============================================================
# STAGE 1 — Build front-end assets (Tailwind/Vite)
# Dijalankan setiap kali image di-build, jadi public/build SELALU
# hasil compile terbaru dari resources/**/*.blade.php & app.css.
# Folder public/build sendiri tetap di .gitignore — tidak perlu
# dikomit, karena di sinilah dia dibuat.
# ============================================================
FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

# Vite/Tailwind @source butuh lihat file blade untuk tahu class apa saja
# yang dipakai, jadi seluruh source project di-copy sebelum build.
COPY . .
RUN npm run build


# ============================================================
# STAGE 2 — Aplikasi PHP (image final yang dijalankan)
# ============================================================
FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libonig-dev libxml2-dev \
    libcurl4-openssl-dev libssl-dev \
    zip unzip git curl nginx supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd pdo pdo_mysql zip bcmath \
        pcntl mbstring xml curl opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Timpa public/build bawaan (kalau ada sisa lokal) dengan hasil build
# fresh dari stage "assets" di atas — ini yang benar-benar dipakai.
COPY --from=assets /app/public/build ./public/build

# Copy composer files dulu sebelum install
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction --ignore-platform-reqs

RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/www.conf /usr/local/etc/php-fpm.d/zzz-custom.conf
COPY docker/fpm-pool.conf /usr/local/etc/php-fpm.d/zzz-pool.conf
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80
CMD ["/entrypoint.sh"]