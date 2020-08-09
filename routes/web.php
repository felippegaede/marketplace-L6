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

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/product/{slug}', 'HomeController@single')->name('product.single');
Route::get('/category/{slug}', 'CategoryController@index')->name('category.single');
Route::get('/store/{slug}', 'StoreController@index')->name('store.single');

Route::prefix('cart')->name('cart.')->group(function(){

    Route::post('/add', 'CartController@add')->name('add');
    Route::get('/', 'CartController@index')->name('index');
    Route::get('/remove/{slug}', 'CartController@remove')->name('remove');
    Route::get('/cancel', 'CartController@cancel')->name('cancel');
});

Route::prefix('checkout')->name('checkout.')->group(function(){

    Route::get('/', 'CheckoutController@index')->name('index');
    Route::post('/process', 'CheckoutController@process')->name('process');
    Route::get('/thanks', 'CheckoutController@thanks')->name('thanks');
});

Route::get('my-orders', 'UserOrderController@index')->name('user.orders');

Route::group(['middleware' => ['auth', 'access.control.store.admin']], function(){

        Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function () {

        Route::resource('/stores', 'StoreController');
        Route::resource('/products', 'ProductController');
        Route::resource('/categories', 'CategoryController');

        Route::post('/photos/remove', 'ProductPhotoController@remove')->name('photo.remove');
        Route::get('orders/my', 'OrdersController@index')->name('orders.my');
        Route::get('notifications', 'NotificationsController@notifications')->name('notifications.index');
        Route::get('notifications/read-all', 'NotificationsController@readAll')->name('notifications.read.all');
        Route::get('notifications/read/{notification}', 'NotificationsController@read')->name('notifications.read');


    });
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
// Route::prefix('stores')->name('stores.')->group(function(){

//     // Route::get('/', 'StoreController@index')->name('index');
//     // Route::get('/create', 'StoreController@create')->name('create');
//     // Route::post('/store', 'StoreController@store')->name('store');
//     // Route::get('/{store}/edit', 'StoreController@edit')->name('edit');
//     // Route::post('/update/{store}', 'StoreController@update')->name('update');
//     // Route::get('/destroy/{store}', 'StoreController@destroy')->name('destroy');

// });
