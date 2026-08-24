<div class="widget_contact ">
    <div class="widget-content">
        @if (!empty($args['icon']))
        <div class="icon-bx">
            <img src="{{ DzHelper::getStorageImage('storage/magic-editor/'.$args['icon']) }}" style="height:100px;" width="auto" alt="/" class="">
        </div>
        @endif
        @if (!empty($args['title']))
        <h4>{{$args['title']}}</h4>
        @endif
        @if (!empty($args['number']))
        <div class="phone-number">{{$args['number']}}</div>
        @endif
        @if (!empty($args['email']))
        <h6 class="email">{{$args['email']}}</h6>
        @endif

        @if (!empty($args['button']))
        <div class="link-btn">
            <a href="{{$args['button_url'] ?? 'javascript:void(0);'}}" class="btn btn-dark btn-skew">
                <span>{{$args['button_text']}}</span>     
            </a>
        </div>
        @endif
    </div>
</div>