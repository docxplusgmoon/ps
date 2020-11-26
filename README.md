# Требования
* PHP 7.3
* PostgreSQL
* Расширение php.pdo_pgsql

# Запуск
* Создаем БД и указываем его в файле в .env
* Запускаем `composer install`
* Запускаем миграции `php artisan migrate`
* Запускаем сиды `php artisan db:seed`

После этого проект готов. На главной должен быть отчет об операциях.
В корне проекта есть Postman коллекция `ps.postman_collection.json` для методов API


# Nginx
Актуальный конфиг для nginx такой:

`
server {
    listen 80;
    server_name payment-system.loc;
    root /home/docx/PhpstormProjects/ps/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
`
