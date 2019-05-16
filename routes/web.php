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

if (env('LOGIN_PROVIDER', 'saml2') === 'password') {
    Route::prefix('auth')->group(function () {
        Auth::routes([
            'register' => false,
            'reset' => false,
        ]);
    });
} else {
    Route::post('/auth/logout', 'Users\LogoutController')
        ->name('logout');
}

Route::middleware('auth')->group(function () {
    Route::get('search', 'SearchController')
        ->name('search');
});

Route::get('{any?}', function ($any = null) {
    return view('home');
})
    ->where('any', '.*')
    ->name('home');
