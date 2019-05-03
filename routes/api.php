<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->group(function () {
    Route::get('types', 'ItemTypeController@jsonIndex')
        ->name('api.types.index');

    Route::put('types/{type}', 'ItemTypeController@update')
        ->name('api.types.update');

    Route::get('types/{type}/suggest-location', 'ItemTypeController@suggestLocations')
        ->name('api.types.suggestLocations');

    Route::post('types/{type}/update-stock', 'ItemTypeController@updateStock')
        ->name('api.types.updateStock');

    Route::get('instances', 'ItemInstanceController@jsonIndex')
        ->name('api.instances.index');

    Route::put('instances/{instance}', 'ItemInstanceController@update')
        ->name('api.instances.update');

    Route::get('locations', 'LocationController@jsonIndex')
        ->name('api.locations.index');

    Route::put('locations/{location}', 'LocationController@update')
        ->name('api.locations.update');
});
