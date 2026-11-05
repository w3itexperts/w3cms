<?php

use Modules\AppManager\Http\Controllers\W3appsController;
use Modules\AppManager\Http\Controllers\DownloadHistoryController;

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

Route::controller(W3appsController::class)->middleware(['auth:sanctum', 'verified'])->name('admin.appmanager.')->prefix('admin/app-manager')->group(function() {
    Route::get('/index', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::get('/delete/{id}', 'destroy')->name('delete');
    Route::match(['get', 'post'], '/edit_w3app_file/{id}', 'edit_w3app_file')->name('edit_w3app_file');
    Route::match(['get', 'post'], '/delete_w3app_file/{id}', 'destroy_w3app_file')->name('delete_w3app_file');
    Route::match(['get', 'post'], '/themes', 'themes')->name('themes');
    Route::match(['get', 'post'], '/plugins', 'plugins')->name('plugins');
    Route::match(['get', 'post'], '/upload_theme/{id?}', 'upload_theme')->name('upload_theme');
    Route::match(['get', 'post'], '/upload_plugin/{id?}', 'upload_plugin')->name('upload_plugin');
    Route::get('/view/{id}', 'view_w3app')->name('view_w3app');
    Route::match(['get', 'post'], '/admin_themes', 'admin_themes')->name('admin_themes');
    Route::match(['get', 'post'], '/upload_admin_theme/{id?}', 'upload_admin_theme')->name('upload_admin_theme');


});

Route::controller(DownloadHistoryController::class)->middleware(['auth:sanctum', 'verified'])->prefix('admin/download-history')->group(function() {
    Route::get('/', 'index')->name('admin.download-history');
    Route::get('/reports', 'reports')->name('admin.download-history.reports');
});