<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PassportAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['prefix' => 'api', 'namespace' => '\App\Http\Controllers\Auth'], function ($api) {
    $api->post('login', 'AuthController@login');
    $api->post('register', 'AuthController@register');
});


$api->version('v1', ['prefix' => 'api', 'middleware' => ['auth:api'], 'namespace' => '\App\Http\Controllers\Auth'], function ($api) {
    $api->post('logout', 'AuthController@logout');
});

$api->version('v1', ['prefix' => 'api', 'namespace' => '\App\Http\Controllers\Api'], function ($api) {
    $api->get('customer/list', 'CustomerApiController@customerList');
    $api->post('customer/store', 'CustomerApiController@customerCreate');
    $api->put('customer/update/{id}', 'CustomerApiController@customerUpdate');
    $api->delete('customer/delete/{id}', 'CustomerApiController@customerDelete');
});
