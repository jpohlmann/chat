<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('users',  ['uses' => 'UserController@fetchAll']);

    $router->get('users/{id}', ['uses' => 'UserController@fetchOne']);

    $router->post('users', ['uses' => 'UserController@create']);

    $router->delete('users/{id}', ['uses' => 'UserController@delete']);

    $router->put('users/{id}', ['uses' => 'UserController@update']);
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('messages',  ['uses' => 'MessageController@fetchAll']);

    $router->get('messages/{id}', ['uses' => 'MessageController@fetchOne']);

    $router->post('messages', ['uses' => 'MessageController@create']);

    $router->delete('messages/{id}', ['uses' => 'MessageController@delete']);

    $router->put('messages/{id}', ['uses' => 'MessageController@update']);
});