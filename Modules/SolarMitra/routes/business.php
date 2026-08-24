<?php

use Illuminate\Support\Facades\Route;
use Modules\SolarMitra\App\Models\Attachment;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\MaterialCategory;
use Modules\SolarMitra\App\Models\MaterialCompany;
use Spatie\Permission\Models\Permission;
use Modules\SolarMitra\Helper\SolarMitraHelper;


Route::middleware('guest.business')->controller(AuthController::class)->group(function () {
    Route::match(['get','post'],'/register', 'register')->name('solarmitra.auth.register');
    Route::match(['get','post'],'/login', 'login')->name('solarmitra.auth.login');
    Route::post('/check-user-exists', 'check_user_exists')->name('solarmitra.auth.check_user_exists');
    Route::post('/login-with-otp', 'login_with_otp')->name('solarmitra.auth.login_with_otp');
    Route::post('/send-login-otp', 'send_login_otp')->name('solarmitra.auth.send_login_otp');
});
Route::middleware('CheckBusinessAuth:business')->controller(AuthController::class)->group(function () {
    Route::get('/verification', 'verification')->name('solarmitra.auth.verification');
    Route::get('/verify-email', 'verify_email')->name('solarmitra.auth.verify_email');
    Route::get('/verify-mobile', 'verify_mobile')->name('solarmitra.auth.verify_mobile');
    Route::post('/verify-user', 'verify_user')->name('solarmitra.auth.verify_user');
    Route::post('/resend-otp', 'resend_otp')->name('solarmitra.auth.resend_otp');
    
    Route::get('/update-contact', 'update_contact_form')->name('solarmitra.auth.update_contact_form');
    Route::post('/update-contact', 'update_contact')->name('solarmitra.auth.update_contact');
});


Route::match(['get','post'],'check-lead-followup', function() {
        \Artisan::call('solarmitra:check-lead-followup');
        echo 'success';
});


Route::match(['get','post'],'remove-attachment/{attachment_id}/{project_id?}/{business_id?}', function() {
        
        $attachment = New Attachment;
        $res = $attachment->DeleteAttachment(request()->attachment_id,request()->project_id,request()->business_id);
        
        return response()->json(['success' => $res]);

})->name('solarmitra.remove-attachment');

Route::get('/items-by-cat-and-brand' , function() {
    
    $category = MaterialCategory::firstWhere(['id' => request()->category_id]);
    $company = MaterialCompany::firstWhere(['id' => request()->company_id]);
    $companySlug = Str::slug(@$company->title);

    $query = MaterialLibrary::with('material_unit:id,title')->where('material_company_id', request()->company_id)
        ->where('material_category_id', $category->id ?? null);
    $items = $query->get();

    if ($category && $category->slug === 'structure' && SolarMitraHelper::getBusinessConfig('gi_price_per_kg')) {
        /*$query->update([
            'selling_price' => DB::raw('weight_per_piece * '.SolarMitraHelper::getBusinessConfig('gi_price_per_kg',1))
        ]);*/
    }
    if ($category && $category->slug === 'panel' && SolarMitraHelper::getBusinessConfig($companySlug.'_cost_per_watt')) {
        /*$query->update([
            'selling_price' => DB::raw('panel_wattage * '.SolarMitraHelper::getBusinessConfig($companySlug.'_cost_per_watt',1))
        ]);*/
    }
    return response()->json($items);
    
})->name('solarmitra.get_items_by_cat_and_brand');


$middlewares = ['CheckBusinessAuth:business','EnsureUserVerified'];

$middlewares[] = 'permissions';

// Dashboard always accessible — no permissions check (so users with no permissions see dashboard instead of 403)
Route::middleware(['CheckBusinessAuth:business', 'EnsureUserVerified'])->controller(BusinessController::class)->group(function () {
    Route::get('/', 'dashboard');
    Route::get('/dashboard', 'dashboard')->name('solarmitra.dashboard');
});

Route::middleware($middlewares)->group(function () {

    Route::controller(BusinessController::class)->group(function () {
        Route::get('/invoice-series', 'get_invoice_series')->name('solarmitra.get_invoice_series');
        Route::get('/settings', 'settings')->name('solarmitra.settings');
        Route::post('/save_business/{business_id}', 'save_business')->name('solarmitra.save_business');
        Route::match(['post','get'],'/bank-account/{id?}', 'bank_account')->name('solarmitra.bank_account');
        Route::match(['post','get'],'/bank-account-delete/{id?}', 'bank_account_destroy')->name('solarmitra.bank_account.destroy');
        Route::match(['post','get'],'/address/{id?}', 'address')->name('solarmitra.address');
        Route::get('/address/make-primary/{id}', 'address_make_primary')->name('solarmitra.address_make_primary');
        Route::match(['post','get'],'/address-delete/{id?}', 'address_destroy')->name('solarmitra.address.destroy');
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('/two-factor-authentication', 'store');
        Route::delete('/two-factor-authentication', 'destroy');
        Route::post('/two-factor-recovery-codes', 'regenerateRecoveryCodes');
        Route::match(['get','post'],'/profile', 'profile')->name('solarmitra.users.profile');
        Route::match(['get','post'],'/logout', 'logout')->name('solarmitra.auth.logout');
        Route::post('/users/update/{id}', 'update_user')->name('solarmitra.users.update');
        Route::post('/users/update-password/{id}', 'update_password')->name('solarmitra.users.update-password');
    });

    Route::controller(ProjectsController::class)->prefix('projects')->group(function () {
        Route::get('/', 'index')->name('solarmitra.projects.index');
        Route::get('/dashboard/{id}', 'dashboard')->name('solarmitra.projects.dashboard');
        Route::get('/create', 'create')->name('solarmitra.projects.create');
        Route::post('/store', 'store')->name('solarmitra.projects.store');
        Route::get('/edit/{id}', 'edit')->name('solarmitra.projects.edit');
        Route::post('/update/{id}', 'update')->name('solarmitra.projects.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.projects.destroy');
        Route::match(['get','post'],'/assign-project/{project_id}', 'assign_project')->name('solarmitra.projects.assign_project');
        // project process
        Route::match(['get','post'],'/documents/{project_id}', 'documents')->name('solarmitra.projects.documents');
        Route::match(['get','post'],'/verification/{project_id}', 'verification')->name('solarmitra.projects.verification');
        Route::match(['get','post'],'/subsidy/{project_id}', 'subsidy')->name('solarmitra.projects.subsidy');
        Route::match(['get','post'],'/installation/{project_id}', 'structure')->name('solarmitra.projects.structure');
        Route::match(['get','post'],'/netmeter/{project_id}', 'netmeter')->name('solarmitra.projects.netmeter');
        Route::match(['get','post'],'/handover/{project_id}', 'handover')->name('solarmitra.projects.handover');
        Route::match(['get','post'],'/remove-document/{doc_type}/{project_id}', 'remove_document')->name('solarmitra.projects.remove_document');
        Route::match(['get','post'],'/remove-project-attachment/{project_attachment_id?}', 'remove_project_attachment')->name('solarmitra.projects.remove_project_attachment');

        Route::get('/get-contact-projects/{contact_id?}', 'get_contact_projects')->name('solarmitra.projects.get_contact_projects');
        Route::post('/save-project-phase/{project_id}', 'save_project_phase')->name('solarmitra.projects.save_project_phase');
        Route::get('/archived-projects', 'archived_projects')->name('solarmitra.projects.archived_projects');
        Route::get('/move-to-projects/{project_id}', 'move_to_projects')->name('solarmitra.projects.move_to_projects');
        

    });
    
    Route::controller(TransactionsController::class)->prefix('transactions')->group(function () {
        Route::get('/{project_id?}', 'index')->name('solarmitra.transactions.index');
        Route::get('/create/{type}/{project_id?}', 'create')->name('solarmitra.transactions.create');
        Route::post('/store', 'store')->name('solarmitra.transactions.store');
        Route::get('/edit/{id}', 'edit')->name('solarmitra.transactions.edit');
        Route::post('/update/{id}', 'update')->name('solarmitra.transactions.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.transactions.destroy');

    });
    
    Route::controller(ContactsController::class)->prefix('contacts')->group(function () {

        Route::get('/{project_id?}', 'index')->name('solarmitra.contacts.index')->where('project_id', '[0-9]+');
        Route::get('/create/{project_id?}/{type_id?}', 'create')->name('solarmitra.contacts.create')->where('project_id', '[0-9]+')->where('type_id', '[0-9]+');
        Route::post('/store', 'store')->name('solarmitra.contacts.store');
        Route::get('/edit/{id?}', 'edit')->name('solarmitra.contacts.edit');
        Route::post('/update/{id?}', 'update')->name('solarmitra.contacts.update');
        Route::match(['get','post'],'/assign-type/{id?}', 'assign_type')->name('solarmitra.contacts.assign_type');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.contacts.destroy');
        Route::post('/multi-delete', 'multi_destroy')->name('solarmitra.contacts.multi_destroy');
        Route::match(['get','post'],'/assign_login', 'assign_login')->name('solarmitra.contacts.assign_login');
        Route::get('/verify-user-direct/{contact_id}', 'verify_user_direct')->name('solarmitra.contacts.verify_user_direct');
        Route::get('/verify-user-modal/{contact_id}', 'verify_user_modal')->name('solarmitra.contacts.verify_user_modal');
        Route::post('/verify-user-field/{contact_id}', 'verify_user_field')->name('solarmitra.contacts.verify_user_field');

        Route::match(['get','post'],'/clients', 'clients')->name('solarmitra.contacts.clients');
        Route::match(['get','post'],'/staff', 'staff')->name('solarmitra.contacts.staff');
        Route::match(['get','post'],'/contractors', 'contractors')->name('solarmitra.contacts.contractors');
        Route::match(['get','post'],'/suppliers', 'suppliers')->name('solarmitra.contacts.suppliers');
        Route::match(['get','post'],'/investors', 'investors')->name('solarmitra.contacts.investors');
        Route::match(['get','post'],'/partners', 'partners')->name('solarmitra.contacts.partners');

    });

    Route::controller(BusinessConfigMasterController::class)->prefix('business-config-master')->group(function () {
        Route::match(['get','post'],'/manage/', 'manage')->name('solarmitra.business_config_master.manage');
        Route::get('/reset-business-configs/', 'reset_business_configs')->name('solarmitra.business_config_master.reset_business_configs');
    });
    
    Route::controller(QuotationsController::class)->prefix('quotations')->group(function () {
        Route::get('/{project_id?}', 'index')->name('solarmitra.quotations.index')->where('project_id', '[0-9]+');
        Route::get('/create/{project_id?}', 'create')->name('solarmitra.quotations.create')->where('project_id', '[0-9]+');
        Route::post('/store/{project_id?}', 'store')->name('solarmitra.quotations.store')->where('project_id', '[0-9]+');
        Route::get('/edit/{id?}/{project_id?}', 'edit')->name('solarmitra.quotations.edit');
        Route::get('/show/{id}', 'show')->name('solarmitra.quotations.show');
        Route::post('/update/{id?}/{project_id?}', 'update')->name('solarmitra.quotations.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.quotations.destroy');


        Route::get('/confirm-quotation/{id}', 'confirm_quotation')->name('solarmitra.quotations.confirm_quotation');
        Route::get('/convert-to-invoice/{id}', 'convert_to_invoice')->name('solarmitra.quotations.convert_to_invoice');
        Route::get('/get-item-by-category/{category_id?}', 'get_item_by_category')->name('solarmitra.quotations.get_item_by_category');
        Route::get('/get-brands-by-category/{category_id?}', 'get_brands_by_category')->name('solarmitra.quotations.get_brands_by_category');
        Route::get('/add-quotation-item/{id?}', 'add_quotation_item')->name('solarmitra.quotations.add_quotation_item');
        Route::get('/add-quotation-category/{id?}', 'add_quotation_category')->name('solarmitra.quotations.add_quotation_category');
        Route::get('/ajax-quotation-addmore-item/{id?}', 'ajax_quotation_addmore_item')->name('solarmitra.quotations.ajax_quotation_addmore_item');
        Route::get('/ajax-quotation-items/{quotation_id?}', 'ajax_quotation_items')->name('solarmitra.quotations.ajax_quotation_items');
        Route::get('/share-quotation/{id}', 'share_quotation')->name('solarmitra.quotations.share_quotation');
        Route::get('/ajax-quotation-calculate/{id}', 'ajax_quotation_calculate')->name('solarmitra.quotations.ajax_quotation_calculate');

    });
    
    Route::controller(MaterialsController::class)->prefix('materials')->group(function () {
        Route::get('/', 'index');
        Route::get('/', 'index')->name('solarmitra.materials.index');
        Route::get('/create', 'create')->name('solarmitra.materials.create');
        Route::post('/store', 'store')->name('solarmitra.materials.store');
        Route::get('/edit/{id?}', 'edit')->name('solarmitra.materials.edit');
        Route::get('/show/{id}', 'show')->name('solarmitra.materials.show');
        Route::post('/update/{id?}', 'update')->name('solarmitra.materials.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.materials.destroy');
        Route::get('/export', 'export')->name('solarmitra.materials.export');
        Route::match(['get','post'],'/import', 'import')->name('solarmitra.materials.import');
        Route::get('/get-unit-by-category/{category_id?}', 'get_unit_by_category')->name('solarmitra.materials.get_unit_by_category');

    });
    
    Route::controller(MaterialCategoriesController::class)->prefix('material-categories')->group(function () {
        Route::match(['get', 'post'], '/list/{id?}', 'list')->name('solarmitra.material_categories.list');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.material_categories.destroy');
        Route::get('/move-up/{id}', 'moveup')->name('solarmitra.material_categories.moveup');
        Route::get('/move-down/{id}', 'movedown')->name('solarmitra.material_categories.movedown');

    });
    
    Route::controller(MaterialCompaniesController::class)->prefix('material-companies')->group(function () {
        Route::match(['get', 'post'], '/ajax_modal/{id?}', 'ajax_modal')->name('solarmitra.material_companies.ajax_modal');
        Route::get('/index', 'index')->name('solarmitra.material_companies.index');
        Route::post('/store', 'store')->name('solarmitra.material_companies.store');
        Route::post('/update/{id?}', 'update')->name('solarmitra.material_companies.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.material_companies.destroy');

    });
    
    Route::controller(MaterialUnitsController::class)->prefix('material-units')->group(function () {
        Route::match(['get', 'post'], '/list/{id?}', 'list')->name('solarmitra.material_units.list');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.material_units.destroy');

    });
    
    Route::controller(QuotationItemsController::class)->prefix('quotation-items')->group(function () {
        Route::get('/{quotation_id?}', 'index')->name('solarmitra.quotations_items.index')->where('quotation_id', '[0-9]+');
        Route::get('/create/{quotation_id?}', 'create')->name('solarmitra.quotations_items.create')->where('quotation_id', '[0-9]+');
        Route::post('/store/{quotation_id?}', 'store')->name('solarmitra.quotations_items.store')->where('quotation_id', '[0-9]+');
        Route::get('/edit/{id?}', 'edit')->name('solarmitra.quotations_items.edit');
        Route::get('/update/{id?}', 'update')->name('solarmitra.quotations_items.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.quotations_items.destroy');


    });
    
    Route::controller(InvoicesController::class)->prefix('invoices')->group(function () {
        Route::get('/', 'index')->name('solarmitra.invoices.index');
        Route::get('/create', 'create')->name('solarmitra.invoices.create');
        Route::post('/store', 'store')->name('solarmitra.invoices.store');
        Route::get('/edit/{id?}', 'edit')->name('solarmitra.invoices.edit');
        Route::get('/show/{id}', 'show')->name('solarmitra.invoices.show');
        Route::post('/update/{id?}', 'update')->name('solarmitra.invoices.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.invoices.destroy');
        Route::get('/share-invoice/{id}', 'share_invoice')->name('solarmitra.invoices.share_invoice');
        Route::get('/get-contact-invoices/{contact_id?}', 'get_contact_invoices')->name('solarmitra.invoices.get_contact_invoices');
        Route::match(['get','post'],'/change-to-paid/{id}', 'change_to_paid')->name('solarmitra.invoices.change_to_paid');

    });
    
    Route::controller(LeadsController::class)->prefix('leads')->group(function () {
        Route::get('/', 'index');
        Route::get('/index', 'index')->name('solarmitra.leads.index');
        Route::get('/create', 'create')->name('solarmitra.leads.create');
        Route::post('/store', 'store')->name('solarmitra.leads.store');
        Route::get('/followed/{id}', 'lead_followed')->name('solarmitra.leads.lead_followed');
        Route::get('/details/{id}', 'details')->name('solarmitra.leads.details');
        Route::get('/edit/{id}', 'edit')->name('solarmitra.leads.edit');
        Route::post('/update/{id}', 'update')->name('solarmitra.leads.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.leads.destroy');
        Route::post('/multi-delete', 'multi_destroy')->name('solarmitra.leads.multi_destroy');
        Route::match(['get','post'],'/assign-lead/{lead_id}', 'assign_lead')->name('solarmitra.leads.assign_lead');
        Route::post('/lead-change-stage', 'lead_change_stage')->name('solarmitra.leads.lead_change_stage');
        Route::post('/lead-client-group', 'lead_client_group')->name('solarmitra.leads.lead_client_group');
        Route::post('/lead-source', 'lead_source')->name('solarmitra.leads.lead_source');
        Route::post('/lead-potential', 'lead_potential')->name('solarmitra.leads.lead_potential');
        Route::get('/export', 'export')->name('solarmitra.leads.export');
        Route::match(['get','post'],'/import', 'import')->name('solarmitra.leads.import');
        Route::match(['get','post'],'/client-group/{id?}', 'client_group')->name('solarmitra.leads.client_group');
        Route::match(['get','post'],'/client-group-delete/{id?}', 'destroy_client_group')->name('solarmitra.leads.destroy_client_group');
        Route::match(['get','post'],'/sources/{id?}', 'sources')->name('solarmitra.leads.sources');
        Route::get('/destroy-source/{id?}', 'destroy_source')->name('solarmitra.leads.destroy_source');
        Route::match(['get','post'],'/channels/{id?}', 'channels')->name('solarmitra.leads.channels');
        Route::get('/destroy-channel/{id?}', 'destroy_channel')->name('solarmitra.leads.destroy_channel');

    });
    
    Route::controller(CampaignsController::class)->prefix('campaigns')->group(function () {
        Route::get('/', 'index')->name('solarmitra.campaigns.index');
        Route::get('/create', 'create')->name('solarmitra.campaigns.create');
        Route::post('/store', 'store')->name('solarmitra.campaigns.store');
        Route::get('/edit/{id?}', 'edit')->name('solarmitra.campaigns.edit');
        Route::post('/update/{id?}', 'update')->name('solarmitra.campaigns.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.campaigns.destroy');

    });
    
    Route::controller(BusinessRolesController::class)->prefix('business-roles')->group(function () {
        Route::get('/', 'index');
        Route::get('/dashboard', 'dashboard')->name('solarmitra.business_roles.dashboard');
        Route::get('/index', 'index')->name('solarmitra.business_roles.index');
        Route::get('/create', 'create')->name('solarmitra.business_roles.create');
        Route::post('/store', 'store')->name('solarmitra.business_roles.store');
        Route::get('/edit/{id}', 'edit')->name('solarmitra.business_roles.edit');
        Route::post('/update/{id}', 'update')->name('solarmitra.business_roles.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.business_roles.destroy');

    });

    Route::controller(PermissionsController::class)->prefix('permissions')->name('solarmitra.permissions.')->group(function () {
    
        Route::get('/', 'index')->name('index');
        Route::get('/roles-permissions', 'roles_permissions')->name('roles_permissions');
        Route::get('/get-role-permissions/{id?}', 'get_role_permissions')->name('get-role-permissions');
        Route::get('/user-permissions', 'user_permissions')->name('user_permissions');
        Route::get('/manage-user-permissions/{id}', 'manage_user_permissions')->name('manage_user_permissions');
        Route::get('/manage-role-all-permissions/{id}', 'manage_role_all_permissions')->name('manage-role-all-permissions');
        Route::get('/manage-role-permission/{role_id}/{permission_id}', 'manage_role_permission')->name('manage-role-permission');
        Route::get('/manage-user-permission/{user_id}/{permission_id}', 'manage_user_permission')->name('manage-user-permission');
        Route::get('/delete-user-permission/{user_id}/{permission_id}', 'delete_user_permission')->name('delete-user-permission');
        Route::get('/manage-user-all-permission/{user_id}', 'manage_user_all_permission')->name('manage_user_all_permission');

        Route::get('/temp_permissions', 'temp_permissions')->name('temp_permissions');
        Route::get('/generate_permissions', 'generate_permissions')->name('generate_permissions');
        Route::get('/add_to_permissions', 'add_to_permissions')->name('add_to_permissions');

        Route::post('/permission_by_action', 'permission_by_action')->name('permission_by_action');
        Route::post('/get_users_by_role', 'get_users_by_role')->name('get_users_by_role');
        Route::post('/get_permission_by_user', 'get_permission_by_user')->name('get_permission_by_user');
    });
    
});
