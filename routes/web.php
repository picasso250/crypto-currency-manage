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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get ('/invest/add', 'HomeController@add');
Route::post('/invest/add', 'HomeController@add_do');
Route::delete('/invest/{id}', 'HomeController@delete');
Route::get('/invest/{id}/edit', 'HomeController@edit');
Route::put('/invest/{id}/edit', 'HomeController@edit_do');
Route::get('/invest/refresh/value/real', 'HomeController@refresh_value_real');
