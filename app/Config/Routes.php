<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::login');

$routes->get('/login', 'Auth::login');

$routes->post('/login', 'Auth::checkLogin');

$routes->get('/logout', 'Auth::logout');

$routes->get('/unauthorized', 'Auth::unauthorized');

$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->get('/dashboard', 'Dashboard::index');

    /*
    |--------------------------------------------------------------------------
    | Asset Management
    |--------------------------------------------------------------------------
    */

    // ADMIN ONLY

    $routes->group('', ['filter' => 'admin'], function ($routes) {

        /*
        |--------------------------------------------------------------------------
        | User Management
        |--------------------------------------------------------------------------
        */

        $routes->get('/users', 'Users::index');

        $routes->post('/users/store', 'Users::store');

        $routes->post('/users/update/(:num)', 'Users::update/$1');

        $routes->get('/users/delete/(:num)', 'Users::delete/$1');

    });

    /*
    |--------------------------------------------------------------------------
    | Assets Access
    |--------------------------------------------------------------------------
    | Admin and Staff
    |--------------------------------------------------------------------------
    */

    $routes->get('/assets', 'Assets::index');

    $routes->get('/assets/view/(:num)', 'Assets::view/$1');

    $routes->post('/assets/store', 'Assets::store');

    $routes->post('/assets/update/(:num)', 'Assets::update/$1');

    $routes->get('/assets/delete/(:num)', 'Assets::delete/$1');

});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

$routes->group('api', function ($routes) {

    $routes->post('login', 'Api\\AuthApi::login');

    $routes->get('assets', 'Api\\AssetApi::index');

    $routes->get('assets/(:num)', 'Api\\AssetApi::show/$1');

    $routes->post('assets', 'Api\\AssetApi::create');

    $routes->put('assets/(:num)', 'Api\\AssetApi::update/$1');

    $routes->delete('assets/(:num)', 'Api\\AssetApi::delete/$1');

});