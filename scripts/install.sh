echo "Installing Project..."

composer install
cp .env.example .env
php artisan key:generate

echo "Project Installed!"
