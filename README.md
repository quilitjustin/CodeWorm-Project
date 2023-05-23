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

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=0bc8c47b8cc42e
MAIL_PASSWORD=5fc5feeec3bff4
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="codeowrm101@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"

PUSHER_APP_ID=1596268
PUSHER_APP_KEY=e32d80a9a34cf1f5eaa9
PUSHER_APP_SECRET=c35875a9b98379086e2b
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=ap1


composer update

npm install

php artisan key:generate

php artisan migrate --seed

php artisan serve --host=codeworm.tech --port=80

add APP_CODE_EXECUTOR=url_of_api variable inside .env file



## References
https://laravel.com/docs/9.x/encryption
https://laravel.com/docs/9.x/eloquent-mutators
https://laravel.com/docs/9.x/eloquent-mutators
https://spatie.be/docs/laravel-backup/v7/introduction
https://support.hostinger.com/en/articles/5792082-how-to-solve-the-most-common-composer-issues
https://laravel.com/docs/9.x/mail