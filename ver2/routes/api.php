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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();


    Route::group([
        'middleware' => ['auth'],
        'domain' => 'probasepay.com'
    ], function () {
        Route::post('merchants/new-merchant-step-1', 'App\Http\Controllers\MerchantController@postNewMerchant');
        Route::post('merchants/new-merchant-step-two', 'App\Http\Controllers\MerchantController@postNewMerchantStepTwo');
        Route::post('merchants/new-merchant-step-three', 'App\Http\Controllers\MerchantController@postNewMerchantStepThree');
        Route::post('merchants/new-merchant-step-four', 'App\Http\Controllers\MerchantController@postNewMerchantStepFour');
    });
});*/


/*Route::group([
    'middleware' => ['api']
], function () {
    
    Route::get('/index', 'App\Http\Controllers\ApiController@index');
    

    Route::group(['middleware'=>['auth','jwt.verify']], function(){
        Route::get('merchants/confirm-merchant-exists/{merchantName}/{merchantId?}', 'App\Http\Controllers\ApiController@checkIfMerchantExists');
    });
    
});*/