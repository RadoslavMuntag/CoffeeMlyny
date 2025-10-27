#!/bin/bash
set -e

echo "Starting Laravel application..."

# Wait for PostgreSQL to be ready
echo "Waiting for PostgreSQL..."
until pg_isready -h ${DB_HOST} -p ${DB_PORT} -U ${DB_USERNAME}; do
  echo "PostgreSQL is unavailable - sleeping"
  sleep 2
done

echo "PostgreSQL is up!"

# Check if .env exists, if not copy from .env.example
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

# Generate application key if not set
if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=base64:VtVzvwJDLSgqX5FJ7fpEMk30lERb4J1r5h5qY0ClSWA=" .env; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Run seeders (only if database is empty)
echo "Checking if database needs seeding..."
TABLES=$(php artisan tinker --execute="echo \DB::table('users')->count();")
if [ "$TABLES" == "0" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
else
    echo "Database already seeded, skipping..."
fi

# Create storage link
echo "Creating storage link..."
php artisan storage:link || true

# Clear and cache config
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Application ready!"

# Execute the main command
exec "$@"
