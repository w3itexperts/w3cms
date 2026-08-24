@if (request('project_id'))
<ul class="nav nav-underline gap-3 nav-scroll nav-scroll-auto-xl mb-3 px-4" role="tablist">
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.overview') ? 'active' : '' }}">Overview</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.estimate') ? 'active' : '' }}">Estimate</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="{{ route('business.solarmitra.contacts.index',request('project_id')) }}" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.contacts.index') ? 'active' : '' }}">Contacts</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="{{ route('business.solarmitra.transactions.index',request('project_id')) }}" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.transactions.index') ? 'active' : '' }}">Transaction</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.to_do') ? 'active' : '' }}">To Do</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.tasks') ? 'active' : '' }}">Task</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.attendence') ? 'active' : '' }}">Attendance</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.materials') ? 'active' : '' }}">Material</a>
	</li>
	<li class="nav-item" role="presentation">
		<a href="" class="nav-link py-3 px-1 border-3 {{ Route::is('business.solarmitra.projects.files') ? 'active' : '' }}">Files</a>
	</li>
</ul>
@endif
