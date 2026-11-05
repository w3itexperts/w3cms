<form action="{{ @$transaction->id ? route('business.solarmitra.transactions.update',@$transaction->id) : route('business.solarmitra.transactions.store') }}" enctype="multipart/form-data" method="post" id="TransactionForm" class="AjaxModalForm">	
	@csrf
	<div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
    </div>
	@if (@$project)
		<input type="hidden" name="project_id" value="{{@$project->id}}">
	@endif
	<input type="hidden" name="transfer_type" value="dr">
	<input type="hidden" name="sender_party_id" value="{{optional(auth('business')->user()->contact)->id}}">

	<div class="offcanvas-header d-flex justify-content-between border-5 border-bottom border-primary">
		<div class="d-flex align-items-center gap-3">
			<button type="button" class="btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			<div class="flex-column">
				<h5 class="fs-14 fw-bold m-0">{{ __('solarmitra::solarmitra.payment') }}</h5>
				<p class="m-0 fs-12">{{@$project->title}}</p>
			</div>
		</div>
		<div class="d-flex gap-3">
			<button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
		</div>
	</div>
	<div class="offcanvas-body">
		<div class="d-flex justify-content-between align-items-center  pb-3">
			<h4>{{ __('solarmitra::solarmitra.payment_out') }}</h4>
			<div>
				<div class="position-relative">
					<input class="form-control DateTimePicker w-auto" type="text" name="date" value="{{ old('date',@$transaction->date ?? Carbon\Carbon::now()->format(config('solarmitra.date_time_format'))) }}">
					<div class="position-absolute end-0 me-3 top-50 translate-middle-y">
						<i class="far fa-calendar"></i>
					</div>
				</div>
	            <p class="text-danger error-text date_error m-0"></p>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-6 mb-3">
				{!! SolarMitraHelper::getContactDropdown('reciever_parties','',@$transaction->reciever_party_id) !!}
                <p class="text-danger error-text reciever_party_id_error"></p>
			</div>

			<div class="col-xl-6 mb-3">
				<label class="form-label">{{ __('solarmitra::solarmitra.amount') }} <span class="text-danger">*</span></label>
				<input type="number" class="form-control" name="amount" value="{{ old('amount',@$transaction->amount)}}" step="any">
                <p class="text-danger error-text amount_error"></p>
			</div>

			<div class="col-xl-6 mb-3">
				<label class="form-label">{{ __('solarmitra::solarmitra.transaction_number') }} </label>
				<input type="text" class="form-control" name="transaction_number" readonly value="{{ old('transaction_number',@$transaction->transaction_number) ?? @$newTransactionNumber }}">
                <p class="text-danger error-text transaction_number_error"></p>
			</div>

			<div class="col-6 mb-3">
				<label class="form-label">{{ __('solarmitra::solarmitra.expense_head') }} <span class="text-danger"> *</span></label>
				<select name="transaction_type" class="select2-with-label-single form-control selectpicker" id="TransactionTypeSelectBox" data-project-url="{{ route('business.solarmitra.projects.get_contact_projects',['transaction_id'=>@$transaction->id]) }}" data-live-search="true">
					<option value="" >Select {{ __('solarmitra::solarmitra.expense_head') }}</option>
					@forelse(SolarMitraHelper::getExpenseHead() as $key => $typeArr)
						<option value="{{ $typeArr['slug'] }}" @selected(old('transaction_type',@$transaction_type) == $typeArr['slug'])>{{ $typeArr['title'] }}</option>
					@empty
					@endforelse
				</select>
                <p class="text-danger error-text transaction_type_error"></p>
			</div>

			@if (!@$project->id)
			<div class="col-12 mb-3 " id="TransactionProjectContainer" style="{{ @$transaction_type == 'project-expenses' ? '' : 'display:none;' }}">
				<label class="form-label">{{ __('solarmitra::solarmitra.projects') }} <span class="text-danger"> *</span></label>
				<select name="project_id" class="select2-with-label-single form-control selectpicker" id="TransactionProjectSelect" data-live-search="true">
					<option value="">{{ __('solarmitra::solarmitra.select_project') }}</option>
					@forelse($projects as $project)
						<option value="{{ $project->id }}" @selected(old('project_id',@$transaction->project_id) == $project->id)>{{ $project->title }}</option>
					@empty
					@endforelse
				</select>
                <p class="text-danger error-text project_id_error"></p>
			</div>
			@endif
			
			<div class="col-xl-12 mb-3">
				<label class="form-label mb-1">{{ __('solarmitra::solarmitra.payment_method') }}<span class="text-danger"> *</span></label>
				<div class="d-flex align-items-center gap-3">
					@forelse (config('solarmitra.transfer_modes') as $key => $mode)
						<div class="form-check">
							<input class="form-check-input" type="radio" @checked(@$transaction->transfer_mode == $key) name="transfer_mode" id="Method_{{$key}}" value="{{$key}}" >
							<label class="form-check-label" for="Method_{{$key}}">{{$mode}}</label>
						</div>
					@empty
					@endforelse
				</div>
                <p class="text-danger error-text transfer_mode_error"></p>
			</div>
			
			<div class="col-12 mb-3">
				<label class="form-label" for="description">{{ __('solarmitra::solarmitra.description') }}</label>
				<textarea name="description" class="form-control " id="description" rows="5">{{ old('description',@$transaction->description) }}</textarea>
                <p class="text-danger error-text description_error"></p>
			</div>

			<div class="form-group col-md-12">
				<label class="form-label mb-1">{{ __('solarmitra::solarmitra.attachments') }}</label>
                <div class="d-flex flex-wrap gap-3"> 
                    @php
                        $transaction_attachments = @$transaction->attachments ? @$transaction->attachments : [];
                    @endphp
                    @forelse ($transaction_attachments as $transaction_attachment)
                    <div class="custom-img-upload custom-img-upload-xl upload-image-box uploadNext img-parent-box border-0">
                        <img src="{{ SolarMitraHelper::getAttachmentImage(@$transaction_attachment->id) }}" class="img-for-onchange zoomable" alt="Image" width="150px" height="150px" title="Image" style="display: block;">

                        <button type="button" href="{{ route('business.solarmitra.remove-attachment',$transaction_attachment->id) }}" class=" cancel-img-btn position-absolute" style="display: block; z-index: 2;" aria-label="Close"><i class="icon icon-x"></i></button>
                    </div>
                    @empty
                    @endforelse
                    <div class="custom-img-upload custom-img-upload-xl uploadNext img-parent-box border-0">
                        <img src="{{ asset('images/noimage.jpg') }}" class="img-for-onchange zoomable" alt="Image" width="150px" height="150px" title="Image" style="display: none;">

                        <button type="button" class="cancel-img-btn position-absolute" style="display: none; z-index: 2;" aria-label="Close"><i class="icon icon-x"></i></button>

                        <div class="upload-btn">
                            <input type="file" class="form-control ps-2 img-business-input-onchange" name="transaction_attachments[]" id="transaction_attachments" accept=".png, .jpg, .jpeg, .webp" hidden="">
                            <label class="upload-label border-dashed flex-column justify-content-center text-center rounded dropzone-btn-xl m-0" style="display: flex;" for="transaction_attachments"><i class=" fas fa-plus fs-26"></i></label>
                        </div>
                    </div>
                    @error('transaction_attachments')
                        <p class="text-danger m-0">
                            {{ $message }}
                        </p>
                    @enderror
                	<p class="text-danger error-text transaction_attachments_error"></p>
                </div>
			</div>
			
		</div>
	</div>
</form>
