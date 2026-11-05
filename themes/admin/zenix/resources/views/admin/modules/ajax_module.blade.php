@foreach(($modules ?? []) as $module)
	@include('admin.modules.module_card')
@endforeach
