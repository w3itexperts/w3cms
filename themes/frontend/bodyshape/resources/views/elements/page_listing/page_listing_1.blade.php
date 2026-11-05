@forelse($pages as $page)
    @php
        $single_link = DzHelper::laraPageLink($page->id);
    @endphp
    <div class="{{ ($layout == 'sidebar_full') ? 'col-lg-4' : 'col-lg-6'; }} m-b30">
        <div class="dz-card style-1 overlay-shine">
            <div class="dz-media ">
                <a href="{{$single_link}}">
                    <img src="{{ DzHelper::getStorageImage('storage/page-images/'.@$page->feature_img->value) }}" alt="{{ __('Page Image') }}">
                </a>
            </div>
            <div class="dz-info">
                <div class="dz-meta">
                    <ul>
                        <li class="post-author">
                            <a href="{{DzHelper::author($page->user_id)}}">
                                <span>{{ __('By') }} {{ optional($page->user)->name }}</span>
                            </a>
                        </li>
                        <li class="post-date"><a href="javascript:void(0);">{{ Carbon\Carbon::parse($page->publish_on)->format(config('Site.custom_date_format')) }}</a></li>
                    </ul>
                </div>
                @php
                    if($page->visibility != 'Pu'){
                        $page_visibility = $page->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                    }else {
                        $page_visibility = '';
                    }
                @endphp
                <h4 class="title"><a href="{{$single_link}}">{{ $page_visibility }}{{ Str::limit($page->title, 30, ' ...') }}</a></h4>
                <p>{{ Str::limit($page->excerpt, 60, ' ...') }}</p>
                <a href="{{$single_link}}" class="btn btn-primary btn-skew"><span>{{ __('Read More') }}</span></a>
            </div>
        </div>
    </div>
@empty
<div class="col-md-12 text-center"><strong>{{ __('No records found.') }}</strong></div>
@endforelse