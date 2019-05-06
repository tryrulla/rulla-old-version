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

Route::prefix('auth')->group(function () {
    Auth::routes([
        'register' => false,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::view('/', 'welcome')
        ->name('home');

    Route::get('types', 'ItemTypeController@index')
        ->name('types.index');

    Route::get('types/new', 'ItemTypeController@create')
        ->name('types.create');

    Route::post('types/new', 'ItemTypeController@store');

    Route::get('types/{type}', 'ItemTypeController@show')
        ->name('types.view');

    Route::get('instances', 'ItemInstanceController@index')
        ->name('instances.index');

    Route::get('instances/new', 'ItemInstanceController@create')
        ->name('instances.create');

    Route::post('instances/new', 'ItemInstanceController@store');

    Route::get('instances/{instance}', 'ItemInstanceController@show')
        ->name('instances.view');

    Route::get('locations', 'LocationController@index')
        ->name('locations.index');

    Route::get('locations/new', 'LocationController@create')
        ->name('locations.create');

    Route::post('locations/new', 'LocationController@store');

    Route::get('locations/{location}', 'LocationController@show')
        ->name('locations.view');

    Route::get('reservations', 'ReservationController@index')
        ->name('reservations.index');

    Route::get('reservations/new', 'ReservationController@create')
        ->name('reservations.create');

    Route::post('reservations/new', 'ReservationController@store');

    Route::get('reservations/{reservation}', 'ReservationController@show')
        ->name('reservations.view');
});
