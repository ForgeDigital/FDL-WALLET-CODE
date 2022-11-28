<?php

use App\Http\Controllers\Customer\Resource\Customer\CustomerController;

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

Route::group(['prefix' => 'api/v1'], function ()
{
    // Forge resource routes
    Route::group(['prefix' => 'forge'], function ()
    {
        // Forge main resources

        // Merchant resources accessed on Forge

        // Customer resources accessed on Forge
    });

    // Merchant resource routes
    Route::group(['prefix' => ''], function ()
    {
        // Merchant main resources

        // Forge resources accessed on merchant

        // Customer resources accessed on merchant
    });

    // Customer resource routes
    Route::group(['prefix' => 'customers'], function ()
    {
        // Customer main resources
        Route::post('kyc', [ CustomerController::class, 'store' ]);


        // Forge resources accessed on customer

        // Merchant resources accessed on customer
    });
});
