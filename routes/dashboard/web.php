<?php

use Illuminate\Support\Facades\Route;


Route::group(
    ['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],

     function() {

        Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function()
        {

            Route::get('index','dashboardController@index')->name('index');

            //Categories Routes
            Route::resource('categories', 'CategoryController')->except('show');

            //Products Routes
            Route::resource('products', 'ProductController')->except('show');

            //Client Routes
            Route::resource('clients', 'ClientController')->except('show');
            Route::resource('clients.orders', 'Client\OrderController')->except('show'); 
            
            //Order Routes
            Route::resource('orders', 'OrderController');
            Route::get('orders/{order}/products', 'OrderController@products')->name('orders.products');

            //Users Routes
            Route::resource('users', 'UserController')->except('show');



        });

    });


