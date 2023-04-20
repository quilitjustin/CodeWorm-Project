## Setting up V-Host
<VirtualHost *:80>
    ServerAdmin admin@codeworm.tech
    DocumentRoot "C:\xampp\htdocs\CodeWorm-Project"
    ServerName codeworm.tech
</VirtualHost>

<VirtualHost *:80>
    ServerAdmin admin@codeworm.tech
    DocumentRoot "C:\xampp\htdocs\CodeWorm-Project"
    ServerName admin.codeworm.tech
</VirtualHost>

<VirtualHost *:80>
    ServerAdmin admin@codeworm.tech
    DocumentRoot "C:\xampp\htdocs\CodeWorm-Project"
    ServerName superadmin.codeworm.tech
</VirtualHost>

127.0.0.1 codeworm.tech
127.0.0.1 admin.codeworm.tech
127.0.0.1 superadmin.codeworm.tech

composer update

npm install

php artisan key:generate

php artisan migrate --seed

php artisan serve --host=codeworm.tech --port=80

## References
https://laravel.com/docs/9.x/encryption
https://laravel.com/docs/9.x/eloquent-mutators
https://laravel.com/docs/9.x/eloquent-mutators