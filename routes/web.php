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
Route::get('/', 'HomeController@show')
    ->name('home');

Route::get('/three', 'ThreeDemoController@show')
    ->name('three-demo');

/**
 * salesforce demo routes
 */
Route::get('/salesforce-demo', 'SalesforceDemoController@show')
    ->name('salesforce-demo');

Route::get('/salesforce/oauth2/authenticate', 'SalesforceDemoController@authenticate')
    ->name('salesforce-authenticate');

Route::get('/salesforce/oauth2/callback', 'SalesforceDemoController@callback')
    ->name('salesforce-callback');
