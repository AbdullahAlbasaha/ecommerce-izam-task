
## Installation

1. Clone the repo and `cd` into it
2. Run `composer install` command .
1. Rename or copy `.env.example` file to `.env`
1. Run `php artisan key:generate` command.
1. Copy key and paste in `.env` file Specifically `APP_KEY`.
1. Set your database credentials in your `.env` file
1. Run `php artisan migrate --db:seed` command. to migrate the database and run any seeders necessary.
1. Run `php artisan serve` command .
1. Use `localhost:8000` as url
1. postman collection in path `storage\app\e-commerce izam.postman_collection.json`
1. admin account. User/Password: admin@izam.com/123456.
