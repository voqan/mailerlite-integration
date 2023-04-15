<?php

use Illuminate\Support\Facades\Route;

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
});

Route::get('/', 'App\Http\Controllers\ApiKeyController@index');
Route::post('/api-keys', 'App\Http\Controllers\ApiKeyController@store');
Route::get('/subscribers', 'App\Http\Controllers\SubscriberController@index');
Route::get('/subscribers/create', 'App\Http\Controllers\SubscriberController@create');
Route::post('/subscribers', 'App\Http\Controllers\SubscriberController@store');
Route::delete('/subscribers/{id}', 'App\Http\Controllers\SubscriberController@destroy');
Route::get('/subscribers/{id}/edit', 'App\Http\Controllers\SubscriberController@edit');
Route::put('/subscribers/{id}', 'App\Http\Controllers\SubscriberController@update');

