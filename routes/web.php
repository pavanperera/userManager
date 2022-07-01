<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return redirect('/login');
// });



Route::get('/', [App\Http\Controllers\Auth\AuthController::class, 'index']);
Route::get('/sign-up', [App\Http\Controllers\Auth\AuthController::class, 'signUp']);
Route::post('register', [App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\Auth\AuthController::class, 'login']);


Route::group(['middleware' => ['auth', 'web']], function () {

    Route::post('logout', [App\Http\Controllers\Auth\AuthController::class, 'logout']);
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    // customer pages
    Route::get('/customer/list', [App\Http\Controllers\CustomerController::class, 'index']);
    Route::get('/customer/create', [App\Http\Controllers\CustomerController::class, 'create']);
    Route::get('/customer/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit']);


    // customer store
    Route::post('/customer/store', [App\Http\Controllers\CustomerController::class, 'store']);

    // customer update
    Route::put('/customer/update/{id}', [App\Http\Controllers\CustomerController::class, 'update']);

    // customer delete
    Route::delete('/customer/delete/{id}', [App\Http\Controllers\CustomerController::class, 'destroy']);
});
