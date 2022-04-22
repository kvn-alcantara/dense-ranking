echo "Installing Project..."

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php74-composer:latest \
    composer install --ignore-platform-reqs
cp .env.example .env
./vendor/bin/sail up -d && ./vendor/bin/sail artisan key:generate

echo "Project Installed!"
