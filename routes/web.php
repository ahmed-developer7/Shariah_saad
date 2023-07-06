<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductClassificationController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ScholarController;
use App\Http\Controllers\SectorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectsController;
use \App\Http\Controllers\EmployeesController;
use \App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductDocumentsController;
use App\Http\Controllers\ObservationsController;

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

// Route Components
/*Route::get('layouts/collapsed-menu', [StaterkitController::class, 'collapsed_menu'])->name('collapsed-menu');
Route::get('layouts/full', [StaterkitController::class, 'layout_full'])->name('layout-full');
Route::get('layouts/without-menu', [StaterkitController::class, 'without_menu'])->name('without-menu');
Route::get('layouts/empty', [StaterkitController::class, 'layout_empty'])->name('layout-empty');
Route::get('layouts/blank', [StaterkitController::class, 'layout_blank'])->name('layout-blank');*/


// locale Route
//Route::get('lang/{locale}', [LanguageController::class, 'swap']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin', [StaterkitController::class, 'home'])->name('home');
    Route::get('/admin/home', [StaterkitController::class, 'home'])->name('admin-home');

//projects
    Route::get('admin/projects/{id?}', [ProjectsController::class, 'index'])->name('admin-projects');
    Route::get('admin/add-project', [ProjectsController::class, 'addProject']);
    Route::get('admin/edit-project/{id}/{duplicate?}', [ProjectsController::class, 'editProject']);
    Route::get('admin/excel-export', [ProjectsController::class, 'excelExport'])->name('excel-export');
    Route::get('admin/send-certificate/{id}/{number}/{send?}/{download?}/{all?}', [ProjectsController::class, 'sendCertificate']);
    Route::get('admin/project-history/{id}', [ProjectsController::class, 'projectHistory']);
    Route::get('admin/mm-report', [ProjectsController::class, 'mmReport'])->name('mm-report');


//companies
    Route::get('admin/companies', [CompanyController::class, 'index'])->name('admin-companies');
    Route::get('admin/add-company', [CompanyController::class, 'addCompany']);
    Route::get('admin/edit-company/{id}', [CompanyController::class, 'editCompany']);

//sectors
    Route::get('admin/sectors', [SectorController::class, 'index'])->name('admin-sectors');
    Route::get('admin/add-sector', [SectorController::class, 'addSector']);
    Route::get('admin/edit-sector/{id}', [SectorController::class, 'editSector']);

//product-classification
    Route::get('admin/product-classifications', [ProductClassificationController::class, 'index'])->name('admin-product-classifications');
    Route::get('admin/add-product-classification', [ProductClassificationController::class, 'addProductClassification']);
    Route::get('admin/edit-product-classification/{id}', [ProductClassificationController::class, 'editProductClassification']);

//product-type
    Route::get('admin/product-types', [ProductTypeController::class, 'index'])->name('admin-product-types');
    Route::get('admin/add-product-type', [ProductTypeController::class, 'addProductType']);
    Route::get('admin/edit-product-type/{id}', [ProductTypeController::class, 'editProductType']);

//scholar
    Route::get('admin/scholars', [ScholarController::class, 'index'])->name('admin-scholars');
    Route::get('admin/add-scholar', [ScholarController::class, 'addScholar']);
    Route::get('admin/edit-scholar/{id}', [ScholarController::class, 'editScholar']);

//language
    Route::get('admin/languages', [LanguageController::class, 'index'])->name('admin-languages');
    Route::get('admin/add-language', [LanguageController::class, 'addLanguage']);
    Route::get('admin/edit-language/{id}', [LanguageController::class, 'editLanguage']);

//employees
    Route::get('admin/employees', [EmployeesController::class, 'index'])->name('admin-employees');
    Route::get('admin/add-employee', [EmployeesController::class, 'addEmployee']);
    Route::get('admin/edit-employee/{id}', [EmployeesController::class, 'editEmployee']);

//users
    Route::get('admin/users', [UsersController::class, 'index'])->name('admin-users');
    Route::get('admin/add-user', [UsersController::class, 'addUser']);
    Route::get('admin/edit-user/{id}', [UsersController::class, 'editUser'])->name('edit-user');
    Route::get('admin/update-user-password/{id}', [UsersController::class, 'editUserPassword']);
    Route::post('admin/update-user-password/{id}', [UsersController::class, 'updateUserPassword'])->name('update-user-password');

    Route::get('admin/update-password', [UsersController::class, 'editPassword'])->name('edit-password');
    Route::post('admin/update-password', [UsersController::class, 'updatePassword'])->name('update-password');

    //logout
    Route::get('/logout', 'LoginController@logout')->name('logout.perform');

    //product-documents
    Route::get('admin/product-documents', [ProductDocumentsController::class, 'index'])->name('admin-product-documents');
    Route::get('admin/add-product-document', [ProductDocumentsController::class, 'addProductDocument']);
    Route::get('admin/edit-product-document/{id}', [ProductDocumentsController::class, 'editProductDocument']);
    Route::get('admin/add-documents/{id}/{type}', [ProductDocumentsController::class, 'addDocuments']);

    //observations
    Route::get('admin/observations', [ObservationsController::class, 'index'])->name('admin-observations');
    Route::get('admin/add-observation', [ObservationsController::class, 'addObservation']);
    Route::get('admin/edit-observation/{id}', [ObservationsController::class, 'editObservation']);
    Route::get('admin/observation-history/{id}', [ObservationsController::class, 'observationHistory']);
});

//microsoft login
Route::get('login/microsoft', 'App\Http\Controllers\Auth\LoginController@redirectToProvider')->name('login.microsoft');
Route::get('login/microsoft/callback', 'App\Http\Controllers\Auth\LoginController@handleProviderCallback');

Route::post('hello-sign-callback', [ProjectsController::class, 'helloSignCallback']);

//search certificate
Route::get('search-certificate', [ProjectsController::class, 'searchCertificate']);
Route::post('search-certificate', [ProjectsController::class, 'postCertificate']);

Route::get('signature-request/{project_id}/{certificate_number}/{scholar_id}', [ProjectsController::class, 'signatureRequest'])->name('signature-request');
Route::post('signature-request', [ProjectsController::class, 'uploadSignature'])->name('signature.upload');

//auth
Auth::routes([
    'register' => false,
    'verify' => false
]);

