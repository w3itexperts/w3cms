<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\SolarMitra\App\Models\ConfigMaster;

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


    
Route::get('/mobile/constants' , function() {

    return response()->json([
        'projects_status' => config('solarmitra.projects_status'),
        'projects_attachment_types' => config('solarmitra.projects_attachment_types'),
        'quotations_status' => config('solarmitra.quotations_status'),
        'gst_rates' => config('solarmitra.gst_rates'),
        'business_user_types' => config('solarmitra.business_user_types'),
        'project_kits' => config('solarmitra.project_kits'),
        'project_types' => config('solarmitra.project_types'),
        'projects_capacity' => config('solarmitra.projects_capacity'),
        'abbreviations' => config('solarmitra.abbreviations'),
        'lead_potentials' => config('solarmitra.lead_potentials'),
        'repeat_followups' => config('solarmitra.repeat_followups'),
        'followup_logs_status' => config('solarmitra.followup_logs_status'),
        'subsidy_types' => config('solarmitra.subsidy_type'),
        'client_types' => config('solarmitra.client_types'),
        'payment_terms' => config('solarmitra.payment_terms'),
        'staff_departments' => config('solarmitra.staff_departments'),
        'salary_type' => config('solarmitra.salary_type'),
        'work_location' => config('solarmitra.work_location'),
    ]);

    
});   

Route::get('/mobile/business-configs/{business_id}' , function() {
    $businessId = request('business_id');

    $configs = ConfigMaster::query()
    ->leftJoin('business_config_master as bcm', function ($join) use ($businessId) {
        $join->on('config_master.id', '=', 'bcm.config_master_id')
             ->where('bcm.business_id', $businessId);
    })
    ->select(
        'config_master.id',
        'config_master.field_key',
        'config_master.field_value as default_value'
    )
    ->selectRaw('COALESCE(bcm.field_value, config_master.field_value) as value')
    ->get();

    
    if (!empty($configs) && $configs->isNotEmpty()) {
        $configurations = $configs->pluck('value','field_key')->toArray();
    }else{
        $configurations = [];
    }

    return response()->json($configurations);

    
});

Route::controller(AuthController::class)->prefix('mobile')->group(function () {
    Route::post('/login/email', 'login_with_email');
    Route::post('/login/email-password', 'login_with_password');
    Route::post('/login/mobile', 'login_with_mobile');
    Route::post('/verify-otp', 'verify_otp');
});

Route::middleware('auth:sanctum','permissions')->prefix('mobile')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::get('/profile', 'profile');
        Route::post('/logout', 'logout');
    });

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'dashboard');
    });

    Route::controller(ProjectsController::class)->prefix('projects')->group(function () {
        Route::get('/list', 'list');
        Route::post('/add', 'save_project');
        Route::post('/update/{project_id}', 'save_project');
        Route::post('/delete/{project_id}', 'destroy');
        Route::post('/assign-staff/{project_id}', 'assign_staff');
        Route::post('/documents/{project_id}', 'documents');
        Route::post('/verification/{project_id}', 'verification');
        Route::post('/subsidy/{project_id}', 'subsidy');
        Route::post('/structure/{project_id}', 'structure');
        Route::post('/netmeter/{project_id}', 'netmeter');
        Route::post('/handover/{project_id}', 'handover');
        Route::post('/remove-review-video/{feedback_id}', 'remove_review_video')->name('solarmitra.projects.remove_review_video');
        Route::post('/remove-document/{doc_type}/{project_id}', 'remove_document')->name('solarmitra.projects.remove_document');
        Route::post('/remove-project-attachment/{project_attachment_id}', 'remove_project_attachment')->name('solarmitra.projects.remove_project_attachment');
    });

    Route::controller(ContactsController::class)->prefix('contacts')->group(function () {
        Route::get('/list', 'list');
        Route::post('/add', 'store');
        Route::post('/delete/{id}', 'destroy');
    });

    Route::controller(QuotationsController::class)->prefix('quotations')->group(function () {
        Route::get('/list', 'list');
        Route::get('/dropdown', 'get_dropdown_list');
        Route::post('/add', 'save_quotation');
        Route::post('/update/{id}', 'save_quotation');
        Route::post('/delete/{id}', 'destroy');
        Route::post('/status-change/{id}', 'status_change');
        Route::post('/item/delete/{id}', 'item_destroy');
        Route::post('/convert-to-invoice/{id}', 'convert_to_invoice');
        Route::get('/view-quotation/{id}', 'view_quotation');
        Route::get('/download-quotation/{id}', 'download_quotation');
    });

    Route::controller(InvoicesController::class)->prefix('invoices')->group(function () {
        Route::get('/list', 'list');
        Route::post('/add', 'store');
        Route::post('/delete/{id}', 'destroy');
        Route::post('/update/{id}', 'update');
        Route::get('/show/{id}', 'show');
        Route::get('/view-invoice/{id}', 'view_invoice');
        Route::get('/download-invoice/{id}', 'download_invoice');
        Route::post('/change-to-paid/{id}', 'change_to_paid');
    });

    Route::controller(MaterialsController::class)->prefix('materials')->group(function () {
        Route::get('/list', 'list');
        Route::get('/categories/{project_id?}', 'get_category_with_company');
        Route::get('/companies/{category_id}', 'get_companies_by_category');
        Route::get('/items/{company_id}/{category_id}', 'get_items_by_company_and_category');
        Route::get('/items/{category_id}', 'get_items_by_company_and_category');
        Route::get('/get-item-by-category/{category_id?}', 'get_item_by_category')->name('solarmitra.quotations.get_item_by_category');
    });
    
    Route::controller(LeadsController::class)->prefix('leads')->group(function () {
        Route::get('/', 'index');
        Route::post('/save-multiple', 'save_multiple');
        Route::get('/lead-resources', 'lead_resources');
        Route::post('/save-lead/{id?}', 'save_lead');
        Route::post('/delete/{id}', 'destroy');
        Route::post('/assign-lead/{lead_id}', 'assign_lead');

    });

    Route::controller(AppFeedbacksController::class)->prefix('app-feedbacks')->group(function () {
        Route::post('/add', 'store');
    });

    Route::controller(TransactionsController::class)->prefix('transactions')->group(function () {
        Route::get('/list', 'list');
        Route::get('/show/{id}', 'show');
        Route::post('/add', 'store');
        Route::post('/update/{id}', 'update');
        Route::post('/delete/{id}', 'destroy');

        Route::get('/get-expense-head', 'get_expense_head');
        Route::get('/get-income-head', 'get_income_head');
    });

});