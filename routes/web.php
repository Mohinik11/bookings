<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/customers', 'CustomersController@getAllCustomers');

$router->get('/customer/{id}', 'CustomersController@getCustomerById');

$router->get('/rooms', 'RoomsController@getAllRooms');

$router->get('/room/{id}', 'RoomsController@getRoomById');

$router->put('/customer/bonus', 'CustomersController@updateCustomerBonusPoints');

$router->post('/booking', 'BookingsController@createBooking');
