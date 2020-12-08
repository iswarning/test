Step 1:
cp .env.example .env

Step 2:
composer install

Step 3:
npm install

Step 4:
npm run dev

Step 5:
php artisan vendor:publish --tag=jetstream-views

Step 6:
php artisan migrate:fresh --seed

Step 7:
php artisan key:generate

Step 8:
php artisan serve