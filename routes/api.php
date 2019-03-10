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

$buildRoute = function ($url, $controller, $router) {
    $router->get("/" . $url, $controller . "@index");
    $router->post("/" . $url, $controller . "@create");
    $router->get("/" . $url . "/{id}", $controller . "@index");
    $router->put("/" . $url . "/{id:[0-9]+}", $controller . "@update");
    $router->delete("/" . $url . "/{id:[0-9]+}", $controller . "@delete");
};

$router->group(['prefix' => env('DOCUMENT_API_BASE_PATH')], function () use ($router, $buildRoute) {

    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    $router->get('/health', function () use ($router) {
        return "OK";
    });

    $router->post('auth/tokens', [
            'uses' => 'AuthController@login'
        ]
    );

    $router->post('/users', 'Users\UserController@create');

    $router->group(['middleware' => 'auth.jwt'], function () use ($router, $buildRoute) {

        $router->group(['namespace' => 'Users'], function () use ($router) {
            $router->get('/users', 'UserController@index');
        });

        $router->group(['namespace' => 'Documents'], function () use ($router, $buildRoute) {
            $buildRoute('documents', 'DocumentController', $router);
        });
    });
});
