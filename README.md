Look at the [Nuxt documentation](https://nuxt.com/docs/getting-started/introduction) to learn more.

## Spesification

Frontend : nuxt.Js
Backend : Laravel version 11
PHP version :  8.2
Database : postgres




## Setup Frontend

Make sure to install dependencies:

```bash
# npm
npm install


Start the development server on `http://localhost:3000`:

```bash
# npm
npm run dev

```
Check out the [deployment documentation](https://nuxt.com/docs/getting-started/deployment) for more information.




## Setup Backend How to Start

Install Vendor
```bash
# composer
composer install
```

Run Genereate App key
```bash
# Generate App key
php artisan key:generate
```

Run Migration
```bash
# Run Migration
php artisan migrate
```

Run Seeder
```bash
#Run Seeder
php artisan db:seed --class=UserAkunSeeder
```

Run Aplication on port 8000
```bash
#Run App
php artisan serve
```

