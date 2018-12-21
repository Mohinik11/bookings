# Booking Microservice is used for booking a room by customer using bonus points

It contains endpoints related to romms, bookings, customers

## Getting Started

These instructions will get you a copy of the project up and running on your machine

### Installing & Running

Docker based:

1. Extract microservice.zip folder
2. open terminal, and run following commands
3. `cd {location to microservice}\microservices\bookings`
4. `composer install`
5. `docker-compose up`
6. Application should run on http://localhost:8000


Manual Installation:

### Prerequisites
PHP 5 >= 5.3.0 / PHP 7
Apache
Mysql

1. Extract microservice.zip folder
2. open terminal, and run following commands
3. `cd {location to microservice}\microservices\bookings`
4. `composer install`
5. `php -S localhost:8000 -t public`
6. Application should run on http://localhost:8000


## Running tests

1. open terminal, and run following commands
2. `cd {location to microservice}\microservice\bookings`
3. `php artisan migrate`
4. `php artisan db:seed`
5. `vendor/bin/phpunit tests`

_____________________________________________________________
We can set email configurations within config/mail.php file 
Here, change username and password for gmail account.