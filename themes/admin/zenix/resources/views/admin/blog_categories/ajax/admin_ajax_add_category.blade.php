@if($category)
	@if($category->parent_id)
		<ul class="category-checkbox-list mx-0">
			<li class="mx-0">
				<input type="checkbox" name="data[BlogCategory][]" class="blog_categories form-check-input" value="{{ $category->id }}">
				{{ $category->title }}
			</li>
		</ul>
	@else
		<li>
			<input type="checkbox" name="data[BlogCategory][]" class="blog_categories form-check-input" value="{{ $category->id }}">
			{{ $category->title }}
		</li>
	@endif
@else
	<li class="text-danger CatNotExit">
		{{ __('common.category_exits.') }}
	</li>
@endif


