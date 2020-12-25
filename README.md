## Requirements

- php7.4
- mysql
- composer
- (optional) npm
- xampp for windows will have php and mysql

## Instructions

- clone the repo
- open the project folder
- copy .env.example to a new file named .env
- change database credentials in .env file
- open a cmd in the project directory and run `composer install`
- then run, `php artisan key:generate`
- then, `php artisan storage:link`
- create a database using any db manager you have, i.e. phpmyadmin
- (optional) run `npm install` if you face any issues in styling after running the project
- run the project using this command, `php artisan serve`

## Keys that need to be changed in .env file

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kitetail
DB_USERNAME=root
DB_PASSWORD=
