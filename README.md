# How to Install
## Setting up V-Host
Add the following inside the httpd-vhosts. You can find it here xampp>apache>conf>extra
Note: You may have to change the path of DocumentRoot based on the location of your project

```
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
```

Add this inside hosts. You can find it here C>Windows>System32>drivers>etc

```
127.0.0.1 codeworm.tech
127.0.0.1 admin.codeworm.tech
```

## Installation
Run the following commands in your terminal inside the project directory
Note: Make sure to setup the .env file first before running the commands below. Db credentials, pusher credentials for broadcasting, mail credentials for notification email. Add APP_CODE_EXECUTOR=url_of_api variable inside .env file if you are going to use execute other language aside PHP and Javascript, change the url_of_api to actual url (You can use [judge0](https://judge0.com/) and host it using (localtunnell[https://theboroer.github.io/localtunnel-www/]) if you can't affort VPS).

```
composer update

npm install

php artisan key:generate

php artisan migrate --seed

php artisan serve --host=codeworm.tech --port=80
```

## Login Credentials

```
Username: superadmin@gmail.com
Password: @qwerty123
```