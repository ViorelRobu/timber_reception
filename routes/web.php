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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/suppliers', 'SuppliersController@index');    
    Route::get('/countries', 'CountriesController@index');
    Route::get('/supplier_group', 'SupplierGroupController@index');    
    Route::get('/supplier_status', 'SupplierStatusController@index');
    Route::get('/suppliers/fetch', 'SuppliersController@fetchSuppliers')->name('suppliers.data');
});

Auth::routes();
