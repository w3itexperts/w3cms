{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')
<div class="container-fluid">
	<div class="card">
		<form action="{{ route('admin.solarmitra.config_master.store')}}" method="post">
			@csrf
			<div class="card-body" id="ConfigFormContainer">
				@include('solarmitra::admin.elements.config_master.form')
			</div>
			<div class="card-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">
					<i class="icon icon-save"></i>
					Save
				</button>
			</div>
		</form>
	</div>
</div>


@endsection