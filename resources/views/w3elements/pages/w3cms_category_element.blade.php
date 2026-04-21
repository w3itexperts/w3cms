@php
    $categories = HelpDesk::elementCategoriesByArgs($args);
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
        <div class="w3-row">
            @forelse($categories as $category)
            <div class="w3-cat-col">
                <div class="category-box swiper-category-box">
                    <div class="category-media">    
                        @if(optional($category)->image && Storage::exists('public/category-images/'.$category->image))
                            <img src="{{ asset('storage/category-images/'.$category->image) }}" alt="">
                        @else
                            <img src="{{ asset('images/noimage.jpg') }}" alt="">
                        @endif
                    </div>
                    <div class="category-info">
                        <a href="{{ DzHelper::laraBlogCategoryLink($category->id) }}" class="category-title">{{  $category->title  }}</a>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        @if (isset($args['pagination']) && ($args['pagination'] == true))
        <div class="w3-pagination">
            {!! $categories->links('elements.pagination') !!}
        </div>
        @endif
    </div>
</section>