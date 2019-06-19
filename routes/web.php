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
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/suppliers', 'SuppliersController@index')->name('suppliers.index');    
    Route::get('/countries', 'CountriesController@index')->name('countries.index');
    Route::get('/supplier_group', 'SupplierGroupController@index')->name('supplier_group.index');    
    Route::get('/supplier_status', 'SupplierStatusController@index')->name('supplier_status.index');
});

Auth::routes();


