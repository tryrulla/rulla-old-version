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
})->name('home');

Route::get('types', 'ItemTypeController@index')
    ->name('types.index');

Route::get('types/new', 'ItemTypeController@create')
    ->name('types.create');

Route::post('types/new', 'ItemTypeController@store');

Route::get('types/{type}', 'ItemTypeController@show')
    ->name('types.view');

Route::get('types/{type}/edit', 'ItemTypeController@edit')
    ->name('types.edit');

Route::get('instances', 'ItemInstanceController@index')
    ->name('instances.index');

Route::get('instances/{instance}', 'ItemInstanceController@show')
    ->name('instances.view');

Route::get('instances/{instance}/edit', 'ItemInstanceController@edit')
    ->name('instances.edit');

Route::get('locations', 'LocationController@index')
    ->name('locations.index');

Route::get('locations/{location}', 'LocationController@show')
    ->name('locations.view');
