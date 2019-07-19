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

    Route::get('/', 'CompanySelectorController@index');
    Route::get('/set_company', 'CompanySelectorController@setCompany');

    Route::group(['middleware' => 'verify.company'], function () {
        Route::get('dashboard', 'HomeController@index')->name('home');
        Route::prefix('suppliers')->group(function() {
            Route::get('/', 'SuppliersController@index')->name('suppliers.index');
            Route::get('/fetch', 'SuppliersController@fetchSuppliers')->name('suppliers.fetch');
            Route::post('/add', 'SuppliersController@store');   
            Route::patch('/{suppliers}/update', 'SuppliersController@update');
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
        Route::prefix('vehicles')->group(function() {
            Route::get('/', 'VehiclesController@index')->name('vehicles.index');
            Route::get('/fetch', 'VehiclesController@fetchVehicle')->name('vehicles.fetch');
            Route::post('/add', 'VehiclesController@store');
            Route::patch('/{vehicle}/update', 'VehiclesController@update');
        });
        Route::prefix('certifications')->group(function () {
            Route::get('/', 'CertificationsController@index')->name('certifications.index');
            Route::get('/fetch', 'CertificationsController@fetchCertifications')->name('certifications.fetch');
            Route::post('/add', 'CertificationsController@store');
            Route::patch('/{certification}/update', 'CertificationsController@update');
        });
        Route::prefix('nir')->group(function () {
            Route::get('/', 'NIRController@index')->name('nir.index');
            Route::get('/fetch', 'NIRController@fetchNIR')->name('nir.fetch');
            Route::post('/add', 'NIRController@store');
            Route::patch('/{nir}/update', 'NIRController@update');
        });
    });
});

Auth::routes();


