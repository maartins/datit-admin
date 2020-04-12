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
    return redirect('/clients');
});

Route::get('/clients', 'Clients@index');
Route::post('/clients/create', 'Clients@new');
Route::get('/clients/edit/{id}', 'Clients@edit');
Route::post('/clients/update/{id}', 'Clients@update');
Route::get('/clients/delete/{id}', 'Clients@delete');

Route::get('/services', 'Services@index');
Route::post('/services/create', 'Services@new');
Route::get('/services/edit/{id}', 'Services@edit');
Route::post('/services/update/{id}', 'Services@update');
Route::get('/services/delete/{id}', 'Services@delete');