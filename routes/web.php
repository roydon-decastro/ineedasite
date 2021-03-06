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


Auth::routes();

/*
Manual Logout if logout is not available yet
*/
Route::get('/logout-manual', function(){
    request()->session()->invalidate();
});

Route::get('/{any}', 'AppController@index')->where('any','.*')->middleware('auth')->name('home');
