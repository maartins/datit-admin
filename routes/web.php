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
    return redirect('/work');
});

Route::get('/work', 'Work@index');

Route::get('/clients', 'Clients@index');
Route::post('/clients/new', 'Clients@new');
Route::get('/clients/edit/{client}', 'Clients@edit');
Route::post('/clients/update/{client}', 'Clients@update');
Route::get('/clients/delete/{client}', 'Clients@delete');

Route::get('/devices', 'Devices@index');
Route::get('/devices/edit/{device}', 'Devices@edit');
Route::post('/devices/update/{device}', 'Devices@update');
Route::get('/devices/delete/{device}', 'Devices@delete');

Route::get('/services', 'Services@index');
Route::post('/services/new', 'Services@new');
Route::get('/services/edit/{service}', 'Services@edit');
Route::post('/services/update/{service}', 'Services@update');
Route::get('/services/delete/{service}', 'Services@delete');

Route::get('/invoices', 'Invoices@index');
Route::get('/invoices/add/{client_id}', 'Invoices@add');
Route::post('/invoices/new/', 'Invoices@new');
Route::get('/invoices/view/{id}', 'Invoices@view');
Route::get('/invoices/view_client/{client_id}/{invoice_id?}', 'Invoices@viewClient');
Route::get('/invoices/delete/{id}', 'Invoices@delete');