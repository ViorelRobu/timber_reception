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

// to do - implement middleware instead of gate for company_was_selected

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'CompanySelectorController@index');
    Route::get('/set_company', 'CompanySelectorController@setCompany');

    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::prefix('suppliers')->group(function() {
        Route::get('/', 'SuppliersController@index')->name('suppliers.index');
        Route::post('/add', 'SuppliersController@store');   
    });
    Route::prefix('countries')->group(function() {
        Route::get('/', 'CountriesController@index')->name('countries.index');
        Route::get('/fetch', 'CountriesController@fetchCountry')->name('countries.fetch');
        Route::post('/add', 'CountriesController@store');
        Route::patch('/{countries}/update', 'CountriesController@update');
    });
    Route::prefix('supplier_group')->group(function() {
        Route::get('/', 'SupplierGroupController@index')->name('supplier_group.index');
        Route::get('/fetch', 'SupplierGroupController@fetchSupplierGroup')->name('supplier_group.fetch');
        Route::post('/add', 'SupplierGroupController@store');
        Route::patch('/{supplier_group}/update', 'SupplierGroupController@update'); 
    });
    Route::prefix('supplier_status')->group(function() {
        Route::get('/', 'SupplierStatusController@index')->name('supplier_status.index');
        Route::get('/fetch', 'SupplierStatusController@fetchSupplierStatus')->name('supplier_status.fetch');
        Route::post('/add', 'SupplierStatusController@store');
        Route::patch('/{supplier_status}/update', 'SupplierStatusController@update');
    });
    Route::prefix('companies')->group(function() {
        Route::get('/', 'CompanyInfoController@index')->name('companies.index');
        Route::get('/fetch', 'CompanyInfoController@fetchCompanyInfo')->name('companies.fetch');
        Route::post('/add', 'CompanyInfoController@store');
        Route::patch('/{company_info}/update', 'CompanyInfoController@update');
        Route::prefix('assign')->group(function() {
            Route::get('/', 'CompanyAssignmentsController@index')->name('user_assignment.index');
            Route::post('/add', 'CompanyAssignmentsController@store');
            Route::delete('/delete', 'CompanyAssignmentsController@destroy');
            Route::get('/loadCompanies', 'CompanyInfoController@loadUnassignedCompanies')->name('loadUnassignedCompanies');
        });
    });
});

Auth::routes();


