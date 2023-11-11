1. Добавить базу данных 
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=movie_laravel
   DB_USERNAME=postgres
   DB_PASSWORD=postgres
2. npm install
3. npm run build
4. php artisan key:generate
5. php artisan migrate --seed
6. php artisan storage:link
7. php artisan serve
