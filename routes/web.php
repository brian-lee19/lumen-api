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

use Illuminate\Http\Request;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'api'
], function () use ($router) {
    $router->post('login', 'API\UserController@login');
    $router->post('register', 'API\UserController@register');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('users/{user_id}', 'API\UserController@details');
    });
});