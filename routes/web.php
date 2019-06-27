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
    Route::post('suppliers/add', 'SuppliersController@store');   
    Route::get('/countries', 'CountriesController@index')->name('countries.index');
    Route::get('/countries/fetch', 'CountriesController@fetchCountry')->name('countries.fetch');
    Route::post('/countries/add', 'CountriesController@store');
    Route::patch('/countries/{countries}/update', 'CountriesController@update');
    Route::get('/supplier_group', 'SupplierGroupController@index')->name('supplier_group.index'); 
    Route::post('/supplier_group/add', 'SupplierGroupController@store');   
    Route::get('/supplier_status', 'SupplierStatusController@index')->name('supplier_status.index');
    Route::post('/supplier_status/add', 'SupplierStatusController@store'); 
    Route::get('/info', 'CompanyInfoController@index')->name('info.index');
});

Auth::routes();


