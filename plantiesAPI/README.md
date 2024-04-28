in your php file find it with `php --ini` uncomment `extension=pdo_pgsql` and `extension=pgsql` (removing the ;)
`composer install`
`npm install`
`php artisan storage:link` - symbolic link from public/storage to storage/app/public

`php artisan migrate:fresh --seed` - will automatically add categories and products 

to run
`npm run dev` and `php artisan serve`

my DB part of .env file:

```

DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=wtech
DB_USERNAME=postgres
DB_PASSWORD=a

```

