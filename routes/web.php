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
    Route::get('/test', 'InvoicesController@test');
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
            Route::get('/invoices', 'InvoicesController@index')->name('invoices.index');
            Route::get('/fetch', 'NIRController@fetchNIR')->name('nir.fetch');
            Route::get('/invoice/fetch', 'InvoicesController@fetchInvoice')->name('invoice.fetch');
            Route::get('/details/fetch', 'NIRDetailsController@fetchDetails')->name('details.fetch');
            Route::post('/add', 'NIRController@store');
            Route::post('/details/add', 'NIRDetailsController@store');
            Route::group(['middleware' => 'verify.invoice'], function () {
                Route::post('/invoice/add', 'InvoicesController@store');
            });
            Route::patch('/invoice/{invoice}/update', 'InvoicesController@update');
            Route::patch('/details/{nir_details}/update', 'NIRDetailsController@update');
            Route::delete('/invoice/delete', 'InvoicesController@destroy');
            Route::delete('/details/delete', 'NIRDetailsController@destroy');
            Route::group(['middleware' => 'nir.rights'], function () {
                Route::get('/{nir}/show', 'NIRController@show');
                Route::get('/{nir}/print', 'NIRController@printNIR');
                Route::patch('/{nir}/update', 'NIRController@update');
            });
        });
        Route::prefix('articles')->group(function () {
            Route::get('/', 'ArticlesController@index')->name('articles.index');
            Route::get('/fetch', 'ArticlesController@fetchArticle')->name('articles.fetch');
            Route::post('/add', 'ArticlesController@store');
            Route::patch('/{article}/update', 'ArticlesController@update');
        });
        Route::prefix('species')->group(function () {
            Route::get('/', 'SpeciesController@index')->name('species.index');
            Route::get('/fetch', 'SpeciesController@fetchSpecies')->name('species.fetch');
            Route::post('/add', 'SpeciesController@store');
            Route::patch('/{species}/update', 'SpeciesController@update');
        });
        Route::prefix('moisture')->group(function () {
            Route::get('/', 'MoistureController@index')->name('moisture.index');
            Route::get('/fetch', 'MoistureController@fetchMoisture')->name('moisture.fetch');
            Route::post('/add', 'MoistureController@store');
            Route::patch('/{moisture}/update', 'MoistureController@update');
        });
        Route::prefix('numbers')->group(function () {
            Route::get('/', 'NumbersController@index')->name('numbers.index');
            Route::post('/add', 'NumbersController@store');
        });
        Route::prefix('reception')->group(function () {
            Route::get('/', 'ReceptionCommitteeController@index')->name('reception.index');
            Route::get('/fetch', 'ReceptionCommitteeController@fetchCommitteeMemberDetails')->name('reception_committee.fetch');
            Route::post('/add', 'ReceptionCommitteeController@store');
            Route::patch('/{reception_committee}/update', 'ReceptionCommitteeController@update');
            Route::patch('/{reception_committee}/upload', 'ReceptionCommitteeController@uploadSignature');
        });
    });
});

Auth::routes();


