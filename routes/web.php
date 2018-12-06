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

// routes guest

Route::get('/', 'ProductController@index');

Route::get('/home', function () {
    return view('home');
});
Route::get('/user/profile', function () {
    return view('user.profile');
});

Auth::routes();
Route::get('/products', 'ProductController@index');
Route::get('/products/{id}', 'ProductController@show');
Route::get('/product/colors','ProductController@getColors');
Route::get('/product/price','ProductController@getPrice');

Route::get('/pant','ProductController@getPant');
Route::get('/shirt','ProductController@getShirt');
Route::get('/jeans','ProductController@getJeans');
Route::get('/jacket','ProductController@getJacket');
Route::get('/dress','ProductController@getDress');

// routes user
Route::middleware(['auth'])->group(function () {
    Route::get('/cart','CartController@getCart');
    Route::post('/cart','CartController@add');
    Route::post('/cart/change', 'CartController@changeQuantity');
    Route::delete('/cart/{stock_id}', 'CartController@remove');

    Route::get('/checkout', "CheckoutController@index");
    Route::post('/checkout', "CheckoutController@checkout");
});

// routes admin
Route::get('/admin/login', 'Admin\Auth\LoginController@index');
Route::post('/admin/login', 'Admin\Auth\LoginController@login')->name('admin_login');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function() {
        return view('layouts.admin');
    });
    Route::resource('/admin/products', 'Admin\ProductController');
    Route::resource('/admin/users', 'Admin\UserController');
    Route::resource('/admin/categories', 'Admin\CategoryController');

    // product attributes
    Route::get('/admin/product-attribute/sizes', 'Admin\AttributeController@listSizes');
    Route::get('/admin/product-attribute/colors', 'Admin\AttributeController@listColors');
    Route::post('/admin/product-attribute/sizes', 'Admin\AttributeController@addSize')->name('attributes.add_size');
    Route::post('/admin/product-attribute/colors', 'Admin\AttributeController@addColor')->name('attributes.add_color');
    Route::delete('/admin/product-attribute/sizes/{id}', 'Admin\AttributeController@removeSize')->name('attributes.remove_size');
    Route::delete('/admin/product-attribute/colors/{id}', 'Admin\AttributeController@removeColor')->name('attributes.remove_color');

    // product images
    Route::post('/admin/product/images/upload', 'Admin\ProductController@addImage');
    Route::delete('/admin/product/images/remove/{id}', 'Admin\ProductController@removeImage');
});
