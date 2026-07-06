# Hosting Notes

Upload the contents of this `laravel-perfume` folder to hosting.

Recommended setup:

1. Point the domain document root to the `public` folder.
2. Set PHP version to 8.2 or newer.
3. Create a MySQL database on hosting.
4. Update `.env` with hosting database credentials.
5. Run these commands on hosting if SSH is available:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If shared hosting has no SSH, upload the existing `vendor` folder too, then import the database manually from phpMyAdmin after creating/exporting it locally.

Important writable folders:

- `storage`
- `bootstrap/cache`

Admin login:

- Email: `admin@perfume.test`
- Password: `admin12345`
