git clone <url-du-repo>
cd <nom-du-projet>
composer install
cp .env.example .env
# Configurer .env (DB, APP_URL...)
php artisan key:generate
php artisan migrate --seed
npm install && npm run dev
php artisan serve
