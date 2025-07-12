# Multi-stage Dockerfile for Laravel Application
FROM node:20-alpine AS node-builder

# Set working directory
WORKDIR /app

# Copy package files
COPY package*.json ./

# Install Node.js dependencies
RUN npm ci

# Copy source code
COPY . .

# Build frontend assets
RUN npm run build

# PHP Application Stage
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite \
    sqlite-dev \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    icu-dev \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_sqlite bcmath gd mbstring xml zip intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer*.json ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy application code
COPY . .

# Copy built assets from node stage
COPY --from=node-builder /app/public/build ./public/build

# Create necessary directories and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy environment file
COPY .env.example .env

# Generate application key
RUN php artisan key:generate --no-interaction

# Create SQLite database if it doesn't exist
RUN touch database/database.sqlite \
    && chown www-data:www-data database/database.sqlite \
    && chmod 664 database/database.sqlite

# Run migrations
RUN php artisan migrate --force

# Optimize for production
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Configure Nginx
COPY <<EOF /etc/nginx/http.d/default.conf
server {
    listen 80;
    server_name localhost;
    root /var/www/html/public;
    index index.php index.html index.htm;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

# Create startup script
COPY <<EOF /start.sh
#!/bin/sh
# Start PHP-FPM
php-fpm -D
# Start Nginx
nginx -g "daemon off;"
EOF

RUN chmod +x /start.sh

# Expose port 80
EXPOSE 80

# Start both Nginx and PHP-FPM
CMD ["/start.sh"] 