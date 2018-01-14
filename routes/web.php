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



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'namespace' => 'TMoney'], function() {
    Route::get('donation', 'DonationController@inquiry');
    Route::get('transaction-report', 'ReportController@transactionReport');
    Route::get('topup-prepaid', 'PurchaseController@topupPrepaid');
});