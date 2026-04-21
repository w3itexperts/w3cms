<div class="widget widget_search">
    <div class="search-bx">
        <form action="{{ route('permalink.search') }}" role="search" method="get">
            <div class="search-input-group">
                <input name="s" type="text" class="search-group-input" placeholder="{{ $args['title'] ?? __('Search') }}">
                <span class="search-group-button">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </span> 
            </div>
        </form>
    </div>
</div>