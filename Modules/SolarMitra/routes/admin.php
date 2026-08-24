<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/solarmitra')->name('admin.')->group(function () {

    Route::controller(BusinessesController::class)->prefix('businesses')->group(function () {
        Route::get('/', 'index')->name('solarmitra.businesses.index');
        Route::get('/create', 'create')->name('solarmitra.businesses.create');
        Route::post('/store', 'store')->name('solarmitra.businesses.store');
        Route::get('/edit/{id}', 'edit')->name('solarmitra.businesses.edit');
        Route::post('/update/{id}', 'update')->name('solarmitra.businesses.update');
        Route::get('/destroy/{id}', 'destroy')->name('solarmitra.businesses.destroy');

    });
    
    Route::controller(ConfigMasterController::class)->prefix('config-master')->group(function () {
        Route::get('/', 'index');
        Route::get('/index', 'index')->name('solarmitra.config_master.index');
        Route::get('/create', 'create')->name('solarmitra.config_master.create');
        Route::post('/store', 'store')->name('solarmitra.config_master.store');
        Route::get('/edit/{id}', 'edit')->name('solarmitra.config_master.edit');
        Route::post('/update/{id}', 'update')->name('solarmitra.config_master.update');
        Route::get('/destroy/{id}', 'destroy')->name('solarmitra.config_master.destroy');

        Route::match(['get','post'],'/manage/{module?}', 'manage')->name('solarmitra.config_master.manage');


    });
    
    Route::controller(TransactionTypesController::class)->prefix('transaction-types')->group(function () {
        Route::match(['get','post'],'/', 'list');
        Route::match(['get','post'],'/list/{id?}', 'list')->name('solarmitra.transaction_types.list');
        Route::get('/destroy/{id}', 'destroy')->name('solarmitra.transaction_types.destroy');

    });
    
    Route::controller(ProjectsController::class)->prefix('projects')->group(function () {
        Route::get('/project-phases', 'project_phases');
        Route::match(['get','post'],'/project-phases/list/{id?}', 'project_phases')->name('solarmitra.projects.project_phases');
        Route::match(['get','post'],'/project-phases/view', 'project_phases_view')->name('solarmitra.projects.project_phases_view');
        Route::get('/destory-project-phase/{id}', 'destory_project_phase')->name('solarmitra.projects.destory_project_phase');

    });
    
    Route::controller(MaterialsController::class)->prefix('materials')->group(function () {
        Route::get('/', 'index');
        Route::get('/', 'index')->name('solarmitra.materials.index');
        Route::get('/create', 'create')->name('solarmitra.materials.create');
        Route::post('/store', 'store')->name('solarmitra.materials.store');
        Route::get('/edit/{id?}', 'edit')->name('solarmitra.materials.edit');
        Route::post('/update/{id?}', 'update')->name('solarmitra.materials.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.materials.destroy');
    
        Route::get('/get-unit-by-category/{category_id?}', 'get_unit_by_category')->name('solarmitra.materials.get_unit_by_category');

    });

    Route::controller(QuotationsController::class)->prefix('quotations')->group(function () {

        Route::get('/get-brands-by-category/{category_id?}', 'get_brands_by_category')->name('solarmitra.quotations.get_brands_by_category');
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

    Route::controller(BusinessRolesController::class)->prefix('business-roles')->group(function () {
        Route::get('/index', 'index')->name('solarmitra.business_roles.index');
        Route::get('/create', 'create')->name('solarmitra.business_roles.create');
        Route::post('/store', 'store')->name('solarmitra.business_roles.store');
        Route::get('/edit/{id}', 'edit')->name('solarmitra.business_roles.edit');
        Route::post('/update/{id}', 'update')->name('solarmitra.business_roles.update');
        Route::get('/delete/{id}', 'destroy')->name('solarmitra.business_roles.destroy');

    });

    Route::controller(AppFeedbacksController::class)->prefix('app-feedbacks')->group(function () {
        Route::get('/', 'index')->name('solarmitra.app_feedbacks.index');
    });

    Route::controller(SourcesController::class)->prefix('sources')->group(function () {
        Route::get('/', 'index')->name('solarmitra.sources.index');
        Route::get('/create', 'create')->name('solarmitra.sources.create');
        Route::post('/store', 'store')->name('solarmitra.sources.store');
        Route::get('/edit/{id}', 'edit')->name('solarmitra.sources.edit');
        Route::post('/update/{id}', 'update')->name('solarmitra.sources.update');
        Route::post('/delete/{id}', 'destroy')->name('solarmitra.sources.destroy');
    });

    Route::controller(ChannelsController::class)->prefix('channels')->group(function () {
        Route::get('/', 'index')->name('solarmitra.channels.index');
        Route::get('/create', 'create')->name('solarmitra.channels.create');
        Route::post('/store', 'store')->name('solarmitra.channels.store');
        Route::get('/edit/{id}', 'edit')->name('solarmitra.channels.edit');
        Route::post('/update/{id}', 'update')->name('solarmitra.channels.update');
        Route::post('/delete/{id}', 'destroy')->name('solarmitra.channels.destroy');
    });
});
