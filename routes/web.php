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
$router->group(['middleware' => 'cors'], function ($router){
    $router->post('/login', 'AuthController@login');
    $router->get('/logout', 'AuthController@logout');
    $router->get('/profile', 'AuthController@me');

    $router->group(['prefix' => 'stuffs', 'middleware' => 'auth'], function() use ($router){
        //stastic routes
        $router->get('/', 'StuffController@index');
        $router->get('/data', 'StuffController@index');
        $router->post('/store', 'StuffController@store');
        $router->get('/trash', 'StuffController@trash');

        // dynamic routes
        $router->get('{id}', 'StuffController@show');
        $router->patch('/update/{id}', 'StuffController@update');
        $router->delete('/delete/{id}', 'StuffController@destroy');
        $router->get('/restore/{id}', 'StuffController@restore');
        $router->delete('/permanent/{id}', 'StuffController@deletePermanent');
    });

    $router->group(['prefix' => '/users'], function() use ($router){
        $router->get('/data', 'UserController@index');
        $router->post('/store', 'UserController@store');
        $router->get('/trash', 'UserController@trash');

        $router->get('{id}', 'UserController@show');
        $router->patch('/update/{id}', 'UserController@update');
        $router->delete('/delete/{id}', 'UserController@destroy');
        $router->get('/trash', 'UserController@trash');
        $router->get('/restore/{id}', 'UserController@restore');
        $router->delete('/permanent/{id}', 'UserController@deletePermanent');
    });
    $router->group(['prefix' => 'inbound-stuff', ], function() use ($router){
        $router->get('/data', 'InboundstuffController@index');
        $router->post('store', 'InboundstuffController@store');
        $router->get('recycle-bin', 'InboundstuffController@recycleBin');

        $router->get('detail/{id}', 'InboundstuffController@show');
        $router->patch('update/{id}', 'InboundstuffController@update');
        $router->delete('delete/{id}', 'InboundstuffController@destroy');
        $router->get('restore/{id}', 'InboundstuffController@restore');
        $router->get('force-delete/{id}', 'InboundstuffController@forceDestroy');
    });

    $router->group(['prefix' => 'stuff-stock', 'middleware'=> 'auth'], function() use ($router){
        // $router->get('/', 'StuffStockController@index');
        $router->post('store', 'StuffStockController@store');
        // $router->get('detail/{id}', 'StuffStockController@show');
        // $router->patch('update/{id}', 'StuffStockController@update');
        // $router->delete('delete/{id}', 'StuffStockController@destroy');
        // $router->get('recycle-bin', 'StuffStockController@recycleBin');
        // $router->get('restore/{id}', 'StuffStockController@restore');
        // $router->get('force-delete/{id}', 'StuffStockController@forceDestroy');
        $router->get('add-stock/{id}', 'StuffStockController@forceDestroy');
        // $router->get('sub-stock/{id}', 'StuffStockController@forceDestroy');
        
    });

    $router->group(['prefix' => 'lendings',], function() use ($router){
        $router->get('/', 'LendingController@index');
        $router->post('store', 'LendingController@store');
        $router->get('detail/{id}', 'LendingController@show');
        $router->patch('update/{id}', 'LendingController@update');
        $router->delete('delete/{id}', 'LendingController@destroy');
        // router->get('recycle-bin', 'LendingController@recycleBin');
        // $router->get('restore/{id}', 'LendingController@restore');
        // $router->get('force-delete/{id}', 'LendingController@forceDestroy');
        // $router->get('add-stock/{id}', 'LendingController@forceDestroy');
        // $router->get('sub-stock/{id}', 'LendingController@forceDestroy');

    });

    $router->group(['prefix' => 'restoration',], function() use ($router){
        $router->get('/', 'RestorationController@index');
        $router->post('store', 'RestorationController@store');
    });

    
});


