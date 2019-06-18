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
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/suppliers', 'SuppliersController@index')->name('suppliers.index');    
    Route::get('/countries', 'CountriesController@index');
    Route::get('/supplier_group', 'SupplierGroupController@index');    
    Route::get('/supplier_status', 'SupplierStatusController@index');
});

Auth::routes();


