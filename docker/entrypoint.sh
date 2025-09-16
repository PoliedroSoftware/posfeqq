#!/bin/bash

# Run Laravel setup commands
cd /var/www/html

# Copy environment file
if [ ! -f ".env" ]; then
    cp .env.docker .env
fi

# Generate application key if not set
php artisan key:generate --ansi

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Create storage link
php artisan storage:link

# Set proper permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Execute the main command
exec "$@"