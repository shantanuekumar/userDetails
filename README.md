# laravel_signup

1.Create a database Profile in mysql.

2.Enter the credentials of database in .env.example folder.

3.To install dependencies in your project run this command in cli

$ composer install

4.To migrate your database run

$ php artisan migrate

5.Source the Profile.sql file to your Profile database via mysql command

mysql>source Profile.sql

6.Rename .env.example file to .env

7.Run this command in the root of project folder to generate key

$ php artisan key:generate

8.Start laravel server via cli command

$ php artisan serve

9.Run from localhost laravel_signup/user data/signup.html
