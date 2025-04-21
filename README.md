Инструкция

Минимальные требования сервера для Yii2:

* PHP >= 7.4
* БД MySQL или PostgreSQL
* Дополнительные расширения PHP - mbstring и openssl

Минимальные требования сервера для библиотеки qrcode

* PHP >= 7.4
* Imagick
* GD
* FreeType

1.Скачать репозиторий.


2.Выполнить команду composer install


3.Создать базу данных


4.Настроить файл конфигурации Yii2 config/db.php

* host
* dbname
* username
* password

5.Запустить миграцию php yii migrate

6.В директории web создать папку images

7.Запустить приложение