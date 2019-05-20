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

Route::middleware('auth')->prefix('v1')->group(function () {
    Route::get('', function () {
        return response()->json(['message' => 'Hello, world!']);
    })->name('api.base');

    Route::get('types', 'ItemTypeController@index')
        ->name('api.types.index');

    Route::post('types', 'ItemTypeController@store')
        ->name('api.types.create');

    Route::get('types/{type}', 'ItemTypeController@show')
        ->name('api.types.view');

    Route::put('types/{type}', 'ItemTypeController@update')
        ->name('api.types.update');

    Route::get('types/{type}/suggest-location', 'ItemTypeController@suggestLocations')
        ->name('api.types.suggestLocations');

    Route::post('types/{type}/update-stock', 'ItemTypeController@updateStock')
        ->name('api.types.updateStock');

    Route::get('instances', 'ItemInstanceController@index')
        ->name('api.instances.index');

    Route::post('instances', 'ItemInstanceController@store')
        ->name('api.instances.create');

    Route::get('instances/{instance}', 'ItemInstanceController@show')
        ->name('api.instances.view');

    Route::put('instances/{instance}', 'ItemInstanceController@update')
        ->name('api.instances.update');

    Route::get('locations', 'LocationController@jsonIndex')
        ->name('api.locations.index');

    Route::post('locations', 'LocationController@store')
        ->name('api.locations.create');

    Route::get('locations/{location}', 'LocationController@show')
        ->name('api.locations.view');

    Route::put('locations/{location}', 'LocationController@update')
        ->name('api.locations.update');

    Route::get('reservations', 'ReservationController@jsonIndex')
        ->name('api.reservations.index');

    Route::post('reservations', 'ReservationController@store')
        ->name('api.reservations.create');

    Route::get('reservations/{reservation}', 'ReservationController@show')
        ->name('api.reservations.index');

    Route::put('reservations/{reservation}', 'ReservationController@update')
        ->name('api.reservations.update');

    Route::post('faults', 'ItemFaultController@store')
        ->name('api.faults.create');

    Route::put('faults/{fault}', 'ItemFaultController@update')
        ->name('api.faults.update');

    Route::get('users', 'Users\UserController@index')
        ->name('api.users.index');

    Route::get('users/{user}', 'Users\UserController@show')
        ->name('api.users.view');

    Route::put('users/{user}', 'Users\UserController@update')
        ->name('api.users.update');
});
