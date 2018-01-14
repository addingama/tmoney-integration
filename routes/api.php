<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api\\TMoney'], function () {
    Route::get('/access_token', 'GeneralController@getAccessToken');
    Route::get('/email_check/{email}', 'GeneralController@emailCheck');
    Route::get('/email_verification/{activationCode}', 'GeneralController@emailVerification');
    Route::get('/get_product', 'GeneralController@getProduct');
    Route::get('/get_product/nominal', 'GeneralController@getProductNominal');
});

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api\\TMoney'], function() {
    Route::post('/my_profile', 'GeneralController@myProfile');
    Route::post('/donation', 'DonationController@donation');
    Route::get('/transaction-report', 'ReportController@transactionReport');
    Route::post('/topup-prepaid', 'PurchaseController@topupPrepaid');
});