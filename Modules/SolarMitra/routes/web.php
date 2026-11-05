<?php

use Illuminate\Support\Facades\Route;
use Modules\SolarMitra\App\Http\Controllers\Business\QuotationsController;
use Modules\SolarMitra\App\Http\Controllers\Business\InvoicesController;

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

    Route::get('quotation/view/{id}', [QuotationsController::class, 'view_quotation'])->name('solarmitra.quotations.view_quotation');
    Route::get('quotation/download/{id}', [QuotationsController::class, 'download_quotation'])->name('solarmitra.quotations.download_quotation');
    Route::get('invoice/view/{id}', [InvoicesController::class, 'view_invoice'])->name('solarmitra.invoices.view_invoice');
    Route::get('invoice/download/{id}', [InvoicesController::class, 'download_invoice'])->name('solarmitra.invoices.download_invoice');

