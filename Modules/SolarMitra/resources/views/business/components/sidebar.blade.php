<!--**********************************
	Sidebar Fixed
***********************************-->


@php
    $current_user   = auth('business')->user();
    $user_name      = isset($current_user->full_name) ? $current_user->full_name : '';
    $user_email         = isset($current_user->email) ? $current_user->email : '';
    $userId         = isset($current_user->id) ? $current_user->id : '';
    $userImg        = HelpDesk::user_img($current_user->profile);
@endphp

@php
	$sub_menu_icon = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 7.49999L10 1.66666L17.5 7.49999V16.6667C17.5 17.1087 17.3244 17.5326 17.0118 17.8452C16.6993 18.1577 16.2754 18.3333 15.8333 18.3333H4.16667C3.72464 18.3333 3.30072 18.1577 2.98816 17.8452C2.67559 17.5326 2.5 17.1087 2.5 16.6667V7.49999Z" stroke="#888888" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.5 18.3333V10H12.5V18.3333" stroke="#888888" stroke-linecap="round" stroke-linejoin="round"/></svg>';
@endphp

<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">

            <li class="nav-label first" data-i18n="{{ __('solarmitra::solarmitra.solarmitra') }}">{{ __('solarmitra::solarmitra.solarmitra') }}</li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="icon-house"></i>
                    <span class="nav-text">{{ __('solarmitra::solarmitra.dashboard') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li class="{{ request()->is('business') ? 'mm-active' : '' }}">
                        <a href="{!! url('/business'); !!}">{{ __('solarmitra::solarmitra.dashboard') }}</a>
                    </li>
                </ul>
            </li>

            <li class="nav-label first" data-i18n="{{ __('solarmitra::solarmitra.management') }}">{{ __('solarmitra::solarmitra.management') }}</li>
            @can('SolarMitra > Business > ContactsController > index')
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="icon-contact"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.contacts') }}">{{ __('solarmitra::solarmitra.contacts') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('business.solarmitra.contacts.index') }}">{{ __('solarmitra::solarmitra.listing') }}</a></li>
                </ul>
            </li>
            @endcan
            @canany([
                'SolarMitra > Business > ContactsController > clients', 
                'SolarMitra > Business > ContactsController > staff', 
                'SolarMitra > Business > ContactsController > contractors', 
                'SolarMitra > Business > ContactsController > suppliers', 
                'SolarMitra > Business > ContactsController > investors', 
                'SolarMitra > Business > ContactsController > partners', 
            ])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="icon-users"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.business_user') }}">{{ __('solarmitra::solarmitra.business_user') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('SolarMitra > Business > ContactsController > clients')
                    <li><a href="{{ route('business.solarmitra.contacts.clients') }}">{{ __('solarmitra::solarmitra.clients') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > ContactsController > staff')
                    <li><a href="{{ route('business.solarmitra.contacts.staff') }}">{{ __('solarmitra::solarmitra.staff') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > ContactsController > contractors')
                    <li><a href="{{ route('business.solarmitra.contacts.contractors') }}">{{ __('solarmitra::solarmitra.contractors') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > ContactsController > suppliers')
                    <li><a href="{{ route('business.solarmitra.contacts.suppliers') }}">{{ __('solarmitra::solarmitra.suppliers') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > ContactsController > investors')
                    <li><a href="{{ route('business.solarmitra.contacts.investors') }}">{{ __('solarmitra::solarmitra.investors') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > ContactsController > partners')
                    <li><a href="{{ route('business.solarmitra.contacts.partners') }}">{{ __('solarmitra::solarmitra.partners') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @canany([
                'SolarMitra > Business > LeadsController > index', 
                'SolarMitra > Business > LeadsController > sources',
                'SolarMitra > Business > LeadsController > channels',
                'SolarMitra > Business > CampaignsController > index'
            ])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="icon-headset"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.manage_leads') }}">{{ __('solarmitra::solarmitra.manage_leads') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('SolarMitra > Business > LeadsController > index')
                    <li><a href="{{ route('business.solarmitra.leads.index') }}">{{ __('solarmitra::solarmitra.leads') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > CampaignsController > index')
                    <li><a href="{{ route('business.solarmitra.campaigns.index') }}">{{ __('solarmitra::solarmitra.campaigns') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > LeadsController > sources')
                    <li><a href="{{ route('business.solarmitra.leads.sources') }}">{{ __('solarmitra::solarmitra.sources') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > LeadsController > channels')
                    <li><a href="{{ route('business.solarmitra.leads.channels') }}">{{ __('solarmitra::solarmitra.channels') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @canany([
                'SolarMitra > Business > BusinessRolesController > index', 
                'SolarMitra > Business > BusinessRolesController > dashboard'
            ])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="icon-user-check"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.roles') }}">{{ __('solarmitra::solarmitra.roles') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('SolarMitra > Business > BusinessRolesController > dashboard')
                    <li><a href="{{ route('business.solarmitra.business_roles.dashboard') }}">{{ __('solarmitra::solarmitra.dashboard') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > BusinessRolesController > index')
                    <li><a href="{{ route('business.solarmitra.business_roles.index') }}">{{ __('solarmitra::solarmitra.listing') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @canany([
                'SolarMitra > Business > PermissionsController > index', 
                'SolarMitra > Business > PermissionsController > temp_permissions',
                'SolarMitra > Business > PermissionsController > roles_permissions', 
                'SolarMitra > Business > PermissionsController > user_permissions'
            ])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="icon-shield"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.permissions') }}">{{ __('solarmitra::solarmitra.permissions') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('SolarMitra > Business > PermissionsController > index')
                    <li><a href="{{ route('business.solarmitra.permissions.index') }}">{{ __('solarmitra::solarmitra.all_permissions') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > PermissionsController > temp_permissions')
                    <li><a href="{{ route('business.solarmitra.permissions.temp_permissions') }}">{{ __('solarmitra::solarmitra.all_temp_permissions') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > PermissionsController > roles_permissions')
                    <li><a href="{{ route('business.solarmitra.permissions.roles_permissions') }}">{{ __('solarmitra::solarmitra.role_permissions') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > PermissionsController > user_permissions')
                    <li><a href="{{ route('business.solarmitra.permissions.user_permissions') }}">{{ __('solarmitra::solarmitra.users_permissions') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @canany([
                'SolarMitra > Business > ProjectsController > index', 
                'SolarMitra > Business > ProjectsController > archived_projects'
            ])
            <li class="nav-label first" data-i18n="{{ __('solarmitra::solarmitra.projects') }}">{{ __('solarmitra::solarmitra.projects') }}</li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="icon-presentation"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.projects') }}">{{ __('solarmitra::solarmitra.projects') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('SolarMitra > Business > ProjectsController > index')
                    <li><a href="{{ route('business.solarmitra.projects.index') }}">{{ __('solarmitra::solarmitra.listing') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > ProjectsController > archived_projects')
                    <li><a href="{{ route('business.solarmitra.projects.archived_projects') }}">{{ __('solarmitra::solarmitra.archived_projects') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @can('SolarMitra > Business > QuotationsController > index')
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="icon-file-text"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.quotations') }}">{{ __('solarmitra::solarmitra.quotations') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('business.solarmitra.quotations.index') }}">{{ __('solarmitra::solarmitra.listing') }}</a></li>
                </ul>
            </li>
            @endcan
            @can('SolarMitra > Business > InvoicesController > index')
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="icon-file-text"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.invoices') }}">{{ __('solarmitra::solarmitra.invoices') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('business.solarmitra.invoices.index') }}">{{ __('solarmitra::solarmitra.listing') }}</a></li>
                </ul>
            </li>
            @endcan
            <li class="nav-label first" data-i18n="{{ __('solarmitra::solarmitra.settings') }}">{{ __('solarmitra::solarmitra.others') }}</li>
            @canany([
                'SolarMitra > Business > MaterialsController > index', 
                'SolarMitra > Business > MaterialCategoriesController > list', 
                'SolarMitra > Business > MaterialCompaniesController > index', 
                'SolarMitra > Business > MaterialUnitsController > list'
            ])
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="icon-inspection-panel"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.materials') }}">{{ __('solarmitra::solarmitra.materials') }}</span>
                </a>
                <ul aria-expanded="false">
                    @can('SolarMitra > Business > MaterialsController > index')
                    <li><a href="{{ route('business.solarmitra.materials.index') }}">{{ __('solarmitra::solarmitra.listing') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > MaterialCategoriesController > list')
                    <li><a href="{{ route('business.solarmitra.material_categories.list') }}">{{ __('solarmitra::solarmitra.categories') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > MaterialCompaniesController > index')
                    <li><a href="{{ route('business.solarmitra.material_companies.index') }}">{{ __('solarmitra::solarmitra.companies') }}</a></li>
                    @endcan
                    @can('SolarMitra > Business > MaterialUnitsController > list')
                    <li><a href="{{ route('business.solarmitra.material_units.list') }}">{{ __('solarmitra::solarmitra.material_unit') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @can('SolarMitra > Business > TransactionsController > index')
            <li>
                <a class=" ai-icon" href="{{ route('business.solarmitra.transactions.index') }}" aria-expanded="false">
                    <i class="icon-arrow-left-right"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.transactions') }}">{{ __('solarmitra::solarmitra.transactions') }}</span>
                </a>
            </li>
            @endcan
            @can('SolarMitra > Business > BusinessController > settings')
            <li>
                <a class=" ai-icon" href="{{ route('business.solarmitra.settings') }}" aria-expanded="false">
                    <i class="icon-settings"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.settings') }}">{{ __('solarmitra::solarmitra.settings') }}</span>
                </a>
            </li>
            @endcan
            @can('SolarMitra > Business > BusinessConfigMasterController > manage')
            <li>
                <a class=" ai-icon" href="{{ route('business.solarmitra.business_config_master.manage') }}" aria-expanded="false">
                    <i class="icon-settings-2"></i>
                    <span class="nav-text" data-i18n="{{ __('solarmitra::solarmitra.configurations') }}">{{ __('solarmitra::solarmitra.configurations') }}</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</div>

<!--**********************************
	Sidebar End
***********************************
