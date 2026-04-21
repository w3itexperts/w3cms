@php
    $blogObj = new \app\models\Blog();
    $archives = $blogObj->archiveBlogs();
@endphp
<div class="widget widget_archives">
    <h6 class="widget-title"><span>{{ $args['title'] ?? __('Archives') }}</span></h6>    
    <ul>
        @forelse($archives as $archive)
        <li class="list-item">
            <a href="{{DzHelper::laraBlogArchiveLink($archive->year,$archive->month)}}"> {{ $archive->month_name  }} {{ $archive->year }}</a>  
            @if (!empty($args['show_post_counts']))
                {{ $archive->data  }}
            @endif
        </li>
        @empty
        @endforelse
    </ul>

</div>