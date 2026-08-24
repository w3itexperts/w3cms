<!-- Footer -->
@include('elements/footer_top_bar_1')
@if ($footer_on)
<footer class="site-footer style-1 footer-action bg-dark"id="footer">
	<div class="footer-top">
      	<div class="container">
			<div class="row">
                <div class="col-xl-3 col-md-12 wow fadeInUp" data-wow-delay="0.2s">
                    @php
                        $section1_widgets_ids = array_keys($footer_sections['Section 1'] ?? array());
                        $section1_widgets = DzHelper::getSidebarWidgets($section1_widgets_ids);
                    @endphp
                    @forelse ($section1_widgets ?? array() as $widget)
                        {!! HelpDesk::shortcodeContent($widget->content,'widget') !!}
                    @empty
                    @endforelse
                </div>
                <div class="col-xl-3 col-md-4 wow fadeInUp" data-wow-delay="0.4s">
                    @php
                        $section2_widgets_ids = array_keys($footer_sections['Section 2'] ?? array());
                        $section2_widgets = DzHelper::getSidebarWidgets($section2_widgets_ids);
                    @endphp
                    @forelse ($section2_widgets ?? array() as $widget)
                        {!! HelpDesk::shortcodeContent($widget->content,'widget') !!}
                    @empty
                    @endforelse
                </div>
                <div class="col-xl-3 col-md-4 wow fadeInUp" data-wow-delay="0.6s">
                    @php
                        $section3_widgets_ids = array_keys($footer_sections['Section 3'] ?? array());
                        $section3_widgets = DzHelper::getSidebarWidgets($section3_widgets_ids);
                    @endphp
                    @forelse ($section3_widgets ?? array() as $widget)
                        {!! HelpDesk::shortcodeContent($widget->content,'widget') !!}
                    @empty
                    @endforelse
                </div>
                <div class="col-xl-3 col-md-4 wow fadeInUp" data-wow-delay="0.8s">
                    @php
                        $section4_widgets_ids = array_keys($footer_sections['Section 4'] ?? array());
                        $section4_widgets = DzHelper::getSidebarWidgets($section4_widgets_ids);
                    @endphp
                    @forelse ($section4_widgets ?? array() as $widget)
                        {!! HelpDesk::shortcodeContent($widget->content,'widget') !!}
                    @empty
                    @endforelse
                </div>
            </div>
		</div>
	</div>
    @if(!empty($copyright_title))
    <div class="container">
    	<div class="footer-bottom">
			<div class="text-center">
				<span class="copyright-text">
					<span>{!! $copyright_title !!}</span>
				</span>
			</div>
      </div>
    </div>
    @endif
    <img class="svg-shape-1 rotate-360" src="{{ theme_asset('images/pattern/circle-footer-1.svg') }}" alt="{{__('Image')}} "/>
    <img class="svg-shape-2 rotate-360" src="{{ theme_asset('images/pattern/circle-footer-1.svg') }}" alt="{{__('Image')}} "/>
</footer>
<!-- Footer End -->
@endif
