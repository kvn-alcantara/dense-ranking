echo "Installing Project..."

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed

echo "Project Installed!"
