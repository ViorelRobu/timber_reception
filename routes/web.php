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
        Route::get('dashboard', 'HomeController@index')->name('home')->middleware('can:viewer');
        Route::prefix('suppliers')->group(function() {
            Route::get('/', 'SuppliersController@index')->name('suppliers.index')->middleware('can:user');
            Route::get('/fetch', 'SuppliersController@fetchSuppliers')->name('suppliers.fetch')->middleware('can:user');
            Route::post('/add', 'SuppliersController@store')->middleware('can:user');
            Route::patch('/{suppliers}/update', 'SuppliersController@update')->middleware('can:user');
        });
        Route::prefix('countries')->group(function() {
            Route::get('/', 'CountriesController@index')->name('countries.index')->middleware('can:user');
            Route::get('/fetch', 'CountriesController@fetchCountry')->name('countries.fetch')->middleware('can:user');
            Route::post('/add', 'CountriesController@store')->middleware('can:user');
            Route::patch('/{countries}/update', 'CountriesController@update')->middleware('can:user');
        });
        Route::prefix('supplier_group')->group(function() {
            Route::get('/', 'SupplierGroupController@index')->name('supplier_group.index')->middleware('can:admin');
            Route::get('/fetch', 'SupplierGroupController@fetchSupplierGroup')->name('supplier_group.fetch')->middleware('can:admin');
            Route::post('/add', 'SupplierGroupController@store')->middleware('can:admin');
            Route::patch('/{supplier_group}/update', 'SupplierGroupController@update')->middleware('can:admin');
        });
        Route::prefix('supplier_status')->group(function() {
            Route::get('/', 'SupplierStatusController@index')->name('supplier_status.index')->middleware('can:admin');
            Route::get('/fetch', 'SupplierStatusController@fetchSupplierStatus')->name('supplier_status.fetch')->middleware('can:admin');
            Route::post('/add', 'SupplierStatusController@store')->middleware('can:admin');
            Route::patch('/{supplier_status}/update', 'SupplierStatusController@update')->middleware('can:admin');
        });
        Route::prefix('companies')->group(function() {
            Route::get('/', 'CompanyInfoController@index')->name('companies.index')->middleware('can:superadmin');
            Route::get('/fetch', 'CompanyInfoController@fetchCompanyInfo')->name('companies.fetch')->middleware('can:superadmin');
            Route::post('/add', 'CompanyInfoController@store')->middleware('can:superadmin');
            Route::patch('/{company_info}/update', 'CompanyInfoController@update')->middleware('can:superadmin');
            Route::prefix('assign')->group(function() {
                Route::get('/', 'CompanyAssignmentsController@index')->name('user_assignment.index')->middleware('can:admin');
                Route::post('/add', 'CompanyAssignmentsController@store')->middleware('can:admin');
                Route::delete('/delete', 'CompanyAssignmentsController@destroy')->middleware('can:admin');
                Route::get('/loadCompanies', 'CompanyInfoController@loadUnassignedCompanies')->name('loadUnassignedCompanies')->middleware('can:admin');
            });
        });
        Route::prefix('vehicles')->group(function() {
            Route::get('/', 'VehiclesController@index')->name('vehicles.index')->middleware('can:admin');
            Route::get('/fetch', 'VehiclesController@fetchVehicle')->name('vehicles.fetch')->middleware('can:admin');
            Route::post('/add', 'VehiclesController@store')->middleware('can:admin');
            Route::patch('/{vehicle}/update', 'VehiclesController@update')->middleware('can:admin');
        });
        Route::prefix('certifications')->group(function () {
            Route::get('/', 'CertificationsController@index')->name('certifications.index')->middleware('can:admin');
            Route::get('/fetch', 'CertificationsController@fetchCertifications')->name('certifications.fetch')->middleware('can:admin');
            Route::post('/add', 'CertificationsController@store')->middleware('can:admin');
            Route::patch('/{certification}/update', 'CertificationsController@update')->middleware('can:admin');
        });
        Route::prefix('nir')->group(function () {
            Route::get('/', 'NIRController@index')->name('nir.index')->middleware('can:viewer');
            Route::get('/invoices', 'InvoicesController@index')->name('invoices.index')->middleware('can:user');
            Route::get('/fetch', 'NIRController@fetchNIR')->name('nir.fetch')->middleware('can:user');
            Route::get('/invoice/fetch', 'InvoicesController@fetchInvoice')->name('invoice.fetch')->middleware('can:user');
            Route::get('/details/fetch', 'NIRDetailsController@fetchDetails')->name('details.fetch')->middleware('can:user');
            Route::get('/print_multiple', 'NIRController@showPrintNIRPage')->middleware('can:user');
            Route::post('/print', 'NIRController@printMultipleNIR')->middleware('can:user');
            Route::post('/add', 'NIRController@store')->middleware('can:user');
            Route::post('/details/add', 'NIRDetailsController@store')->middleware('can:user');
            Route::group(['middleware' => 'verify.invoice'], function () {
                Route::post('/invoice/add', 'InvoicesController@store')->middleware('can:user');
            });
            Route::patch('/invoice/{invoice}/update', 'InvoicesController@update')->middleware('can:user');
            Route::patch('/details/{nir_details}/update', 'NIRDetailsController@update')->middleware('can:user');
            Route::delete('/invoice/delete', 'InvoicesController@destroy')->middleware('can:user');
            Route::delete('/details/delete', 'NIRDetailsController@destroy')->middleware('can:user');
            Route::group(['middleware' => 'nir.rights'], function () {
                Route::get('/{nir}/show', 'NIRController@show')->middleware('can:viewer');
                Route::get('/{nir}/print', 'NIRController@printNIR')->middleware('can:user');
                Route::patch('/{nir}/update', 'NIRController@update')->middleware('can:user');
            });
        });
        Route::prefix('articles')->group(function () {
            Route::get('/', 'ArticlesController@index')->name('articles.index')->middleware('can:admin');
            Route::get('/fetch', 'ArticlesController@fetchArticle')->name('articles.fetch')->middleware('can:admin');
            Route::post('/add', 'ArticlesController@store')->middleware('can:admin');
            Route::patch('/{article}/update', 'ArticlesController@update')->middleware('can:admin');
        });
        Route::prefix('species')->group(function () {
            Route::get('/', 'SpeciesController@index')->name('species.index')->middleware('can:admin');
            Route::get('/fetch', 'SpeciesController@fetchSpecies')->name('species.fetch')->middleware('can:admin');
            Route::post('/add', 'SpeciesController@store')->middleware('can:admin');
            Route::patch('/{species}/update', 'SpeciesController@update')->middleware('can:admin');
        });
        Route::prefix('moisture')->group(function () {
            Route::get('/', 'MoistureController@index')->name('moisture.index')->middleware('can:admin');
            Route::get('/fetch', 'MoistureController@fetchMoisture')->name('moisture.fetch')->middleware('can:admin');
            Route::post('/add', 'MoistureController@store')->middleware('can:admin');
            Route::patch('/{moisture}/update', 'MoistureController@update')->middleware('can:admin');
        });
        Route::prefix('numbers')->group(function () {
            Route::get('/', 'NumbersController@index')->name('numbers.index')->middleware('can:admin');
            Route::post('/add', 'NumbersController@store')->middleware('can:admin');
        });
        Route::prefix('reception')->group(function () {
            Route::get('/', 'ReceptionCommitteeController@index')->name('reception.index')->middleware('can:admin');
            Route::get('/fetch', 'ReceptionCommitteeController@fetchCommitteeMemberDetails')->name('reception_committee.fetch')->middleware('can:admin');
            Route::post('/add', 'ReceptionCommitteeController@store')->middleware('can:admin');
            Route::patch('/{reception_committee}/update', 'ReceptionCommitteeController@update')->middleware('can:admin');
            Route::patch('/{reception_committee}/upload', 'ReceptionCommitteeController@uploadSignature')->middleware('can:admin');
            Route::patch('/{reception_committee}/delete', 'ReceptionCommitteeController@deleteSignature')->middleware('can:admin');
        });
        Route::prefix('users')->group(function () {
            Route::get('/', 'UsersController@index')->name('users.index')->middleware('can:superadmin');
            Route::get('/fetch', 'UsersController@fetchUser')->name('users.fetch')->middleware('can:superadmin');
            Route::post('/add', 'UsersController@store')->middleware('can:superadmin');
            Route::patch('/{user}/update', 'UsersController@update')->middleware('can:superadmin');
            Route::patch('/{user_group}/change', 'UsersController@changeRole')->middleware('can:superadmin');
        });
    });
});

Auth::routes(['verify' => false, 'register' => false, 'reset' => false]);


