<li class="nav-label">{{ __('solarmitra::solarmitra.solarmitra') }}</li>
<li>
    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
        <i class="icon-briefcase-business"></i>
        <span class="nav-text">{{ __('solarmitra::solarmitra.businesses') }}</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{ route('admin.solarmitra.businesses.index') }}">{{ __('solarmitra::solarmitra.listing') }}</a></li>
        <li><a href="{{ route('admin.solarmitra.businesses.create') }}">{{ __('solarmitra::solarmitra.add') }}</a></li>
    </ul>
</li>
<li>
    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
        <i class="icon-presentation"></i>
        <span class="nav-text">{{ __('solarmitra::solarmitra.projects') }}</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{ route('admin.solarmitra.projects.project_phases_view') }}">{{ __('solarmitra::solarmitra.project_phases') }}</a></li>
    </ul>
</li>
<li>
    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
        <i class="icon-arrow-left-right"></i>
        <span class="nav-text">{{ __('solarmitra::solarmitra.transaction_types') }}</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{route('admin.solarmitra.transaction_types.list')}}">{{ __('solarmitra::solarmitra.listing') }}</a></li>
    </ul>
</li>
<li>
    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
        <i class="icon-circle-pile"></i>
        <span class="nav-text">{{ __('solarmitra::solarmitra.materials') }}</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{ route('admin.solarmitra.materials.index') }}">{{ __('solarmitra::solarmitra.listing') }}</a></li>
        <li><a href="{{ route('admin.solarmitra.material_categories.list') }}">{{ __('solarmitra::solarmitra.categories') }}</a></li>
        <li><a href="{{ route('admin.solarmitra.material_companies.index') }}">{{ __('solarmitra::solarmitra.companies') }}</a></li>
        <li><a href="{{ route('admin.solarmitra.material_units.list') }}">{{ __('Material Unit') }}</a></li>
    </ul>
</li>
<li>
    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
        <i class="icon-book-user"></i>
        <span class="nav-text">{{ __('Manage Leads') }}</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{ route('admin.solarmitra.sources.index') }}">{{ __('Sources') }}</a></li>
        <li><a href="{{ route('admin.solarmitra.channels.index') }}">{{ __('Channels') }}</a></li>
    </ul>
</li>
<li>
    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
        <i class="icon-user-round-cog"></i>
        <span class="nav-text">{{ __('solarmitra::solarmitra.business_roles') }}</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{ route('admin.solarmitra.business_roles.index') }}">{{ __('solarmitra::solarmitra.listing') }}</a></li>
    </ul>
</li>
<li>
    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
        <i class="icon-settings"></i>
        <span class="nav-text">{{ __('Business Config') }}</span>
    </a>
    <ul aria-expanded="false">
        @foreach (config('solarmitra.business_config.modules') as $module_key => $module_title)
            <li><a href="{{ route('admin.solarmitra.config_master.manage',$module_key) }}">{{ $module_title }}</a></li>
        @endforeach
    </ul>
</li>
<li>
    <a href="{{ route('admin.solarmitra.app_feedbacks.index') }}" class="ai-icon">
        <i class="icon-message-circle"></i>
        <span class="nav-text">{{ __('App Feedbacks') }}</span>
    </a>
</li>