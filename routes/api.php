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

Route::middleware('auth:api')->group(function() {
    Route::get('/templates', 'TemplatesController@index');
    Route::post('/templates', 'TemplatesController@store');
    Route::get('/templates/{template}', 'TemplatesController@show');
    Route::patch('/templates/{template}', 'TemplatesController@update');
    Route::delete('/templates/{template}', 'TemplatesController@destroy');

});