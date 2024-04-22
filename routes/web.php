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

});

$router->post('/login', 'Usercontroller@login');
$router->get('/logout', 'Usercontroller@logout');

$router->group(['prefix' => '/stuff', 'middleware' => 'auth'], function() use ($router){
    //stastic routes
    $router->get('/data', 'StuffController@index');
    $router->post('/', 'StuffController@store');
    $router->get('/trash', 'StuffController@trash');

    // dynamic routes
    $router->get('{id}', 'StuffController@show');
    $router->patch('/{id}', 'StuffController@update');
    $router->delete('/{id}', 'StuffController@destroy');
    $router->get('/restore/{id}', 'StuffController@restore');
    $router->delete('/permanent/{id}', 'StuffController@deletePermanent');
});

$router->group(['prefix' => '/users'], function() use ($router){
    //stastic routes
    $router->get('/data', 'Usercontroller@index');
    $router->post('/', 'Usercontroller@store');
    $router->get('/trash', 'Usercontroller@trash');

    // dynamic routes
    $router->get('{id}', 'Usercontroller@show');
    $router->patch('/{id}', 'Usercontroller@update');
    $router->delete('/{id}', 'Usercontroller@destroy');
    $router->get('/restore/{id}', 'Usercontroller@restore');
    $router->delete('/permanent/{id}', 'Usercontroller@deletePermanent');
});

$router->group(['prefix' => 'inbound-stuff', 'middleware'=> 'auth'], function() use ($router){
    $router->get('/', 'InboundStuffController@index');
    $router->post('store', 'InboundStuffController@store');
    $router->get('detail/{id}', 'InboundStuffController@show');
    $router->patch('update/{id}', 'InboundStuffController@update');
    $router->delete('delete/{id}', 'InboundStuffController@destroy');
    $router->get('recycle-bin', 'InboundStuffController@recycleBin');
    $router->get('restore/{id}', 'InboundStuffController@restore');
    $router->get('force-delete/{id}', 'InboundStuffController@forceDestroy');
});

$router->group(['prefix' => 'stuff-stock', 'middleware'=> 'auth'], function() use ($router){
    // $router->get('/', 'StuffStockController@index');
    // $router->post('store', 'StuffStockController@store');
    // $router->get('detail/{id}', 'StuffStockController@show');
    // $router->patch('update/{id}', 'StuffStockController@update');
    // $router->delete('delete/{id}', 'StuffStockController@destroy');
    // $router->get('recycle-bin', 'StuffStockController@recycleBin');
    // $router->get('restore/{id}', 'StuffStockController@restore');
    // $router->get('force-delete/{id}', 'StuffStockController@forceDestroy');
    $router->get('add-stock/{id}', 'StuffStockController@forceDestroy');
    // $router->get('sub-stock/{id}', 'StuffStockController@forceDestroy');
    
});


