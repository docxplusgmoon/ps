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
