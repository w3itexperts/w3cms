{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-xl-12 text-center">
                                <h3 class="mt-2 mb-3 text-decoration-underline">{{ __('solarmitra::solarmitra.management_department') }}</h3>
                            </div>
                            <div class="col-xl-3 text-center">
                                <h5>{{ __('solarmitra::solarmitra.business_owner') }}</h5>
                                <ul>
                                    <li>Overall company performance</li>
                                    <li>Strategic decisions</li>
                                    <li>Financial overview</li>
                                    <li>Growth planning</li>
                                </ul>
                                 <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Business']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-3 text-center">
                                <h5>{{ __('solarmitra::solarmitra.ceo') }}</h5>
                                <ul>
                                    <li>Overall company performance</li>
                                    <li>Strategic decisions</li>
                                    <li>Financial overview</li>
                                    <li>Growth planning</li>
                                </ul>
                                 <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'CEO']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-3 text-center">
                                <h5>{{ __('solarmitra::solarmitra.operations_manager') }}</h5>
                                <ul>
                                    <li>Oversees daily solar operations</li>
                                    <li>Manages project teams</li>
                                    <li>Ensures installation timelines</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Operations Manager']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-3 text-center">
                                <h5>{{ __('solarmitra::solarmitra.project_manager') }}</h5>
                                <ul>
                                    <li>Manages solar installation projects</li>
                                    <li>Tracks project progress</li>
                                    <li>Coordinates engineers and technicians</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Project Manager']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-12 text-center">
                                <h3 class="mt-5 mb-3 text-decoration-underline">{{ __('solarmitra::solarmitra.sales_department') }}</h3>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>{{ __('solarmitra::solarmitra.sales_manager') }}</h5>
                                <ul>
                                    <li>Manages sales team</li>
                                    <li>Sales targets and pipeline</li>
                                    <li>Lead distribution</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Sales Manager']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>{{ __('solarmitra::solarmitra.sales_executive') }}</h5>
                                <ul>
                                    <li>Handles leads and customers</li>
                                    <li>Generates quotations</li>
                                    <li>Closes solar deals</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Sales Executive']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>CRM / Lead Manager</h5>
                                <ul>
                                    <li>Manages lead database</li>
                                    <li>Assigns leads</li>
                                    <li>Tracks follow-ups</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'CRM / Lead Manager']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-12 text-center">
                                <h3 class="mt-5 mb-3 text-decoration-underline">{{ __('solarmitra::solarmitra.technical_department') }}</h3>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>{{ __('solarmitra::solarmitra.solar_design_engineer') }}</h5>
                                <ul>
                                    <li>System design</li>
                                    <li>Panel layout planning</li>
                                    <li>Capacity calculation</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Solar Design Engineer']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>{{ __('solarmitra::solarmitra.site_survey_engineer') }}</h5>
                                <ul>
                                    <li>Visits customer location</li>
                                    <li>Measures roof area</li>
                                    <li>Checks shading and direction</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Site Survey Engineer']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-4 text-center">
                                @can([
                                    'SolarMitra > Business > BusinessRolesController > create', 
                                    'SolarMitra > Business > BusinessRolesController > store'
                                ])
                                <a href="{{ route('business.solarmitra.business_roles.create') }}" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd" >{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.business_role') }}</a>
                                @endcan
                                <h5>{{ __('solarmitra::solarmitra.add_custom_role') }}</h5>
                                <ul>
                                    <li>Business Can Add a Cutom Role and <br> assign permissions to it.</li>
                                </ul>
                            </div>
                            <div class="col-xl-12 text-center">
                                <h3 class="mt-5 mb-3 text-decoration-underline">{{ __('solarmitra::solarmitra.installation_department') }}</h3>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>{{ __('solarmitra::solarmitra.installation_supervisor') }}</h5>
                                <ul>
                                    <li>Supervises installation teams</li>
                                    <li>Ensures safety standards</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Installation Supervisor']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>{{ __('solarmitra::solarmitra.solar_technician') }}</h5>
                                <ul>
                                    <li>Installs panels, inverter, wiring</li>
                                    <li>Completes installation tasks</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Solar Technician']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-12 text-center">
                                <h3 class="mt-5 mb-3 text-decoration-underline">{{ __('solarmitra::solarmitra.maintenance_department') }}</h3>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>{{ __('solarmitra::solarmitra.service_engineer') }}</h5>
                                <ul>
                                    <li>Handles maintenance requests</li>
                                    <li>Repairs faults</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Service Engineer']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-12 text-center">
                                <h3 class="mt-5 mb-3 text-decoration-underline">Procurement & Inventory</h3>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>{{ __('solarmitra::solarmitra.procurement_manager') }}</h5>
                                <ul>
                                    <li>Purchases panels, inverter, batteries</li>
                                    <li>Vendor coordination</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Procurement Manager']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>{{ __('solarmitra::solarmitra.inventory_manager') }}</h5>
                                <ul>
                                    <li>Tracks equipment stock</li>
                                    <li>Manages warehouse</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Inventory Manager']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-12 text-center">
                                <h3 class="mt-5 mb-3 text-decoration-underline">{{ __('solarmitra::solarmitra.finance_department') }}</h3>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>{{ __('solarmitra::solarmitra.accounts_manager') }}</h5>
                                <ul>
                                    <li>Invoices and payments</li>
                                    <li>Subsidy tracking</li>
                                    <li>Profit & loss reports</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Accounts Manager']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                            <div class="col-xl-12 text-center">
                                <h3 class="mt-5 mb-3 text-decoration-underline">{{ __('solarmitra::solarmitra.customer_support') }}</h3>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h5>{{ __('solarmitra::solarmitra.customer_support') }}</h5>
                                <ul>
                                    <li>Handles customer queries</li>
                                    <li>Installation updates</li>
                                    <li>Service tickets</li>
                                </ul>
                                <a href="{{ route('business.solarmitra.permissions.get-role-permissions', ['name'=>'Customer Support']) }}"
                                   class="btn btn-link"
                                   data-bs-toggle="modal"
                                   data-bs-target="#AjaxModalBoxLg">
                                    <i class="fas fa-key me-1"></i> Check Permissions
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection