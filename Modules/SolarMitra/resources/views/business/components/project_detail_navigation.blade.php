@if (request('project_id'))
<ul class="nav nav-underline gap-3 nav-scroll nav-scroll-auto-xl mb-3 px-4" role="tablist">
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.overview') ? 'active' : '' }}">{{ __('solarmitra::solarmitra.overview') }}</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.estimate') ? 'active' : '' }}">{{ __('solarmitra::solarmitra.estimate') }}</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="{{ route('business.solarmitra.contacts.index',request('project_id')) }}" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.contacts.index') ? 'active' : '' }}">{{ __('solarmitra::solarmitra.contacts_tab') }}</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="{{ route('business.solarmitra.transactions.index',request('project_id')) }}" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.transactions.index') ? 'active' : '' }}">{{ __('solarmitra::solarmitra.transaction_tab') }}</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.to_do') ? 'active' : '' }}">{{ __('solarmitra::solarmitra.to_do') }}</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.tasks') ? 'active' : '' }}">{{ __('solarmitra::solarmitra.task') }}</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.attendence') ? 'active' : '' }}">{{ __('solarmitra::solarmitra.attendance') }}</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.materials') ? 'active' : '' }}">{{ __('solarmitra::solarmitra.material_tab') }}</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.files') ? 'active' : '' }}">{{ __('solarmitra::solarmitra.files') }}</a>
	</li>
</ul>
@endif
