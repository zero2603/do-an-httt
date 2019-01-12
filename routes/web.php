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
Route::get('/search','ProductController@search');
Auth::routes();
Route::get('/products', 'ProductController@index');
Route::get('/products/{id}', 'ProductController@show');
Route::get('/product/colors','ProductController@getColors');
Route::get('/product/price','ProductController@getPrice');

Route::get('/categories', 'ProductController@getCategories');
Route::get('/colors', 'ProductController@getAllColors');
Route::get('/sizes', 'ProductController@getAllSizes');

// routes user
Route::middleware(['auth'])->group(function () {
    Route::get('/cart','CartController@getCart');
    Route::post('/cart','CartController@add');
    Route::post('/cart/change', 'CartController@changeQuantity');
    Route::delete('/cart/{stock_id}', 'CartController@remove');

    Route::get('/checkout', "CheckoutController@index");
    Route::post('/checkout', "CheckoutController@checkout");

    Route::get('/user/profile','ProfileController@index');
    Route::get('/user/profile/edit','ProfileController@edit');
    Route::post('/user/profile/update','ProfileController@update');
    Route::post('/user/profile/update-avatar','ProfileController@updateAvatar');
    Route::post('/user/profile/update-password','ProfileController@updatePassword');

    Route::post('/comment','CommentController@create');
    
    Route::get('/orders', "OrderController@index");
    Route::get('/orders/{id}', "OrderController@show");
});

// routes admin
Route::get('/admin/login', 'Admin\Auth\LoginController@index');
Route::post('/admin/login', 'Admin\Auth\LoginController@login')->name('admin_login');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', 'Admin\StatisticController@index');
    Route::get('/admin/revenue', 'Admin\StatisticController@getRevenue');
    Route::resource('/admin/products', 'Admin\ProductController');
    Route::resource('/admin/users', 'Admin\UserController');
    Route::resource('/admin/categories', 'Admin\CategoryController');
    Route::resource('/admin/orders', 'Admin\OrderController');

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

    // comment
    Route::delete('/admin/comment/{id}','Admin\CommentController@destroy');
});

Route::get('/{productType}','ProductController@getSubProduct');
