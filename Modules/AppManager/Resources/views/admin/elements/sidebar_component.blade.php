<li class="nav-label">{{ __('common.appearance') }}</li>
<li>
    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
        <i class="flaticon-144-layout"></i>
        <span class="nav-text">{{ __('W3Apps') }}</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{ route('admin.appmanager.index') }}">{{ __('appmanager::common.all_w3apps') }}</a></li>
        <li><a href="{{ route('admin.appmanager.create') }}">{{ __('appmanager::common.add_w3app') }}</a></li>
        <li><a href="{{ route('admin.appmanager.themes') }}">{{ __('appmanager::common.all_themes') }}</a></li>
        <li><a href="{{ route('admin.appmanager.upload_theme') }}">{{ __('appmanager::common.upload_theme') }}</a></li>
        <li><a href="{{ route('admin.appmanager.plugins') }}">{{ __('appmanager::common.all_plugins') }}</a></li>
        <li><a href="{{ route('admin.appmanager.upload_plugin') }}">{{ __('appmanager::common.upload_plugin') }}</a></li>
    </ul>
</li>
<li>
    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
        <i class="flaticon-146-download"></i>
        <span class="nav-text">{{ __('common.downloadHistory') }}</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{ route('admin.download-history') }}">{{ __('Index') }}</a></li>
        <li><a href="{{ route('admin.download-history.reports') }}">{{ __('Reports') }}</a></li>
    </ul>
</li>