@php
$author_box_on = config('ThemeOptions.author_box_on',true);
@endphp
@if($author_box_on)
	<div class="author-box blog-user m-b60">
		<div class="author-profile-info">
			<div class="author-profile-pic">
				<img src="{{ HelpDesk::user_img(optional($blog->user)->profile); }}" alt="{{ __("user's profile") }}" />
			</div>
			<div class="author-profile-content">
				<h6>{{ __('By') }} <a href="{{ DzHelper::author(optional($blog->user)->id) }}">{{ optional($blog->user)->name }}</a> </h6>
                <p>{{ CustomFieldHelper::get_custom_field_value('users','user_biography',optional($blog->user)->id); }} </p>
                <ul class="list-inline m-b0">
                    {!! get_social_icons('','') !!}
                </ul>
			</div>
		</div>
	</div>
@endif
