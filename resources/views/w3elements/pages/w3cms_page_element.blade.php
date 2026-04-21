@php
    $pages = HelpDesk::elementPagesByArgs($args);
@endphp

<section class="default-el">
    <div class="w3-container">
        @if (isset($args['title']) || isset($args['view_all']) || isset($args['page_id']))
        <div class="w3-section-head">
            <div class="w3-content">
                <p class="w3-sub-title">{{ isset($args['subtitle']) ? $args['subtitle'] : '' }}</p>
                <h2 class="w3-title">{{ isset($args['title']) ? $args['title'] : '' }}</h2>
                <p class="w3-description">{{ isset($args['description']) ? $args['description'] : '' }}</p>
            </div>

            <div>
                @if (isset($args['view_all']) && $args['view_all'] == 'true')
                <a href="{{ isset($args['page_id']) ? DzHelper::laraPageLink($args['page_id']) : 'javascript:void(0);' }}" class="w3-btn">{{ __('View All') }}</a>
                @endif
            </div>
        </div>
        @endif
        <div class="page-list w3-row">
            @forelse($pages as $page)
            <div class="w3-page-col"> 
				<div class="page-listing-box">
					<h5 class="w3-page-title">{{ $page->title }}</h5>
					<p class="w3-page-excerpt">{{ $page->excerpt }}</p>
					<a class="read-more-btn" href="{{ DzHelper::laraPageLink($page->id) }}">{{ __('Go to Page') }}</a>
				</div>
			</div>
            @empty
            @endforelse
        </div>
        @if (isset($args['pagination']) && ($args['pagination'] == true))
        <div class="w3-pagination">
            {!! $pages->links('elements.pagination') !!}
        </div>
        @endif
    </div>
</section>