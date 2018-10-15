<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/products', 'ProductController@index');
    Route::get('/products/{id}', 'ProductController@show');

    // routes admin
    Route::resource('/admin/products', 'Admin\ProductController');
});