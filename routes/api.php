<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\ProductClassificationController;
use App\Http\Controllers\Api\ProductTypeController;
use App\Http\Controllers\Api\ScholarController;
use App\Http\Controllers\Api\SectorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectsController;
use \App\Http\Controllers\Api\EmployeesController;
use \App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ProductDocumentsController;
use App\Http\Controllers\Api\ObservationsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//projects
Route::get('/get-projects', [ProjectsController::class, 'index']);
Route::post('/delete-certification', [ProjectsController::class, 'deleteCertification']);
Route::post('/delete-termination', [ProjectsController::class, 'deleteTermination']);
Route::get('/get-project-data/{excel?}', [ProjectsController::class, 'getProjectData']);
Route::post('/save-project', [ProjectsController::class, 'store']);
Route::post('/update-project/{id}', [ProjectsController::class, 'update']);
Route::post('/delete-project/{id}', [ProjectsController::class, 'destroy']);
Route::get('/excel-export', [ProjectsController::class, 'excelExport']);
Route::get('/get-project-history/{id}', [ProjectsController::class, 'getProjectHistory']);
Route::get('/generate-mm-report', [ProjectsController::class, 'generateMMReport']);

/*** Companies-List ***/
Route::get('/get-companies', [CompanyController::class, 'index']);
//Route::get('/get-company-data', [CompanyController::class, 'getCompanyData']);
Route::post('/save-company', [CompanyController::class, 'store']);
Route::post('/update-company/{id}', [CompanyController::class, 'update']);
Route::post('/delete-company/{id}', [CompanyController::class, 'destroy']);
Route::post('/update-company-status/{id}', [CompanyController::class, 'updateStatus']);
Route::get('/get-code/{id}', [CompanyController::class, 'getCode']);
Route::post('/delete-company-termination/{id}', [CompanyController::class, 'deleteTermination']);
Route::get('/get-shariyah-companies', [CompanyController::class, 'getShariyahCompanies']);

/*** Sector-List ***/
Route::get('/get-sectors', [SectorController::class, 'index']);
//Route::get('/get-company-data', [SectorController::class, 'getSectorData']);
Route::post('/save-sector', [SectorController::class, 'store']);
Route::post('/update-sector/{id}', [SectorController::class, 'update']);
Route::post('/delete-sector/{id}', [SectorController::class, 'destroy']);
Route::post('/update-sector-status/{id}', [SectorController::class, 'updateStatus']);


//product-classification
Route::get('/get-product-classifications', [ProductClassificationController::class, 'index']);
//Route::get('/get-company-data', [SectorController::class, 'getSectorData']);
Route::post('/save-product-classification', [ProductClassificationController::class, 'store']);
Route::post('/update-product-classification/{id}', [ProductClassificationController::class, 'update']);
Route::post('/delete-product-classification/{id}', [ProductClassificationController::class, 'destroy']);
Route::post('/update-product-classification-status/{id}', [ProductClassificationController::class, 'updateStatus']);
Route::get('/get-product-classification', [ProductClassificationController::class, 'getProductClassification']);


//product-type
Route::get('/get-product-types', [ProductTypeController::class, 'index']);
//Route::get('/get-company-data', [SectorController::class, 'getSectorData']);
Route::post('/save-product-type', [ProductTypeController::class, 'store']);
Route::post('/update-product-type/{id}', [ProductTypeController::class, 'update']);
Route::post('/delete-product-type/{id}', [ProductTypeController::class, 'destroy']);
Route::post('/update-product-type-status/{id}', [ProductTypeController::class, 'updateStatus']);
Route::get('/get-product-type/{id?}', [ProductTypeController::class, 'getProductType']);

//scholar
Route::get('/get-scholars', [ScholarController::class, 'index']);
//Route::get('/get-company-data', [SectorController::class, 'getSectorData']);
Route::post('/save-scholar', [ScholarController::class, 'store']);
Route::post('/update-scholar/{id}', [ScholarController::class, 'update']);
Route::post('/delete-scholar/{id}', [ScholarController::class, 'destroy']);
Route::post('/update-scholar-status/{id}', [ScholarController::class, 'updateStatus']);
Route::get('/check-signature/{id}', [ScholarController::class, 'checkSignature']);

//language
Route::get('/get-languages', [LanguageController::class, 'index']);
//Route::get('/get-company-data', [SectorController::class, 'getSectorData']);
Route::post('/save-language', [LanguageController::class, 'store']);
Route::post('/update-language/{id}', [LanguageController::class, 'update']);
Route::post('/delete-language/{id}', [LanguageController::class, 'destroy']);
Route::post('/update-language-status/{id}', [LanguageController::class, 'updateStatus']);

//employees
Route::get('/get-employees', [EmployeesController::class, 'index']);
Route::post('/delete-employee/{id}', [EmployeesController::class, 'destroy']);
Route::post('/save-employee', [EmployeesController::class, 'store']);
Route::post('/update-employee/{id}', [EmployeesController::class, 'update']);
Route::post('/update-employee-status/{id}', [EmployeesController::class, 'updateStatus']);

//users
Route::get('/get-users', [UsersController::class, 'index']);
Route::post('/delete-user/{id}', [UsersController::class, 'destroy']);
Route::post('/update-user-status/{id}', [UsersController::class, 'updateStatus']);
Route::post('/save-user', [UsersController::class, 'store']);
Route::post('/update-user/{id}', [UsersController::class, 'update']);

//product-document
Route::get('/get-product-documents', [ProductDocumentsController::class, 'index']);
Route::post('/save-product-document', [ProductDocumentsController::class, 'store']);
Route::post('/update-product-document/{id}', [ProductDocumentsController::class, 'update']);
Route::post('/delete-product-document/{id}', [ProductDocumentsController::class, 'destroy']);
Route::post('/update-product-document-status/{id}', [ProductDocumentsController::class, 'updateStatus']);
Route::get('/get-product-document/{id?}', [ProductDocumentsController::class, 'getProductDocument']);
Route::post('/save-documents/{id}/{type}', [ProductDocumentsController::class, 'saveDocuments']);
Route::get('/get-documents-estimate', [ProductDocumentsController::class, 'getDocumentsEstimate']);

//observations
Route::get('/get-observations', [ObservationsController::class, 'index']);
Route::post('/add-observation', [ObservationsController::class, 'store']);
Route::get('/get-observations-companies', [ObservationsController::class, 'getObservationsCompanies']);
Route::get('/get-observations-products/{id?}', [ObservationsController::class, 'getObservationsProducts']);
Route::post('/update-observation-status/{id}', [ObservationsController::class, 'updateStatus']);
Route::post('/delete-observation/{id}', [ObservationsController::class, 'destroy']);
Route::post('/update-observation/{id}', [ObservationsController::class, 'update']);
Route::get('/get-observation-history/{id}', [ObservationsController::class, 'getObservationHistory']);

