<?php

use Illuminate\Http\Request;
use Modules\AppManager\Http\Controllers\W3appsController;

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

Route::middleware('auth:api')->get('/appmanager', function (Request $request) {
    return $request->user();
});

Route::get('/api/themes', [W3appsController::class, 'api_themes'])->name('api_themes');
Route::get('/api/modules', [W3appsController::class, 'api_modules'])->name('api_modules');
Route::get('/api/app_detail', [W3appsController::class, 'app_detail'])->name('app_detail');
Route::post('/api/module_versions', [W3appsController::class, 'api_module_versions'])->name('api_module_versions');
Route::post('/api/install_report', [W3appsController::class, 'api_install_report'])->name('api_install_report');

Route::get('/get-language-file', [W3appsController::class, 'get_language_file']);
Route::get('/client-information-api', [W3appsController::class, 'client_information_api']);
Route::get('/get-main-language-detail', [W3appsController::class, 'get_main_language_detail']);
Route::get('/get-language-detail/', [W3appsController::class, 'get_language_detail']);