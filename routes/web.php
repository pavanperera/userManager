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

Route::get('/', [App\Http\Controllers\Auth\AuthController::class, 'index'])->name('login');
Route::get('/sign-up', [App\Http\Controllers\Auth\AuthController::class, 'signUp']);

// Route::group(['middleware' => ['auth']], function () {

Route::post('logout', [App\Http\Controllers\Auth\AuthController::class, 'logout']);
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// customer pages
Route::get('/customer/list', [App\Http\Controllers\CustomerController::class, 'index']);
Route::get('/customer/create', [App\Http\Controllers\CustomerController::class, 'create']);
Route::get('/customer/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit']);
// });
