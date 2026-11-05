<?php
	$footer_subscribe_on = config('ThemeOptions.footer_subscribe_on');
	$footer_subscribe_title = config('ThemeOptions.footer_subscribe_title');
	$footer_subscribe_desc = config('ThemeOptions.footer_subscribe_desc');
	$footer_subscribe_btn = config('ThemeOptions.footer_subscribe_btn');
?>
@if(!empty($footer_subscribe_on))
  <!-- Call To Action -->
<section class="call-action style-1 footer-action">
	<div class="container">
		<div class="inner-content wow fadeInUp" data-wow-delay="0.8s">
			<div class="row justify-content-between align-items-center">
				<div class="text-center text-lg-start col-xl-6 m-lg-b20">
					@if(!empty($footer_subscribe_title))
						<h2 class="title">{{ $footer_subscribe_title }}</h2>
					@endif
					@if(!empty($footer_subscribe_desc))
					<p>{{ $footer_subscribe_desc }}</p>
					@endif
				</div>
				<div class="text-center text-lg-end col-xl-6">
					<form class="dzSubscribe dz-subscription" action="#" method="post">
						<div class="form-group">
							<div class="input-group mb-0">
								<div class="input-skew ">
                                <input name="dzEmail" required="required" type="email" class="form-control" placeholder="{{ __('Enter Your Email Address...') }}">
								</div>
								@if(!empty($footer_subscribe_btn))
								<div class="input-group-addon">
									<button name="submit" value="Submit" type="submit" class="btn btn-secondary btn-lg btn-skew"><span>{{ $footer_subscribe_btn }}</span></button>
								</div>
								@endif
							</div>
						</div>
						<div class="dzSubscribeMsg dz-subscription-msg text-white"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Call To Action -->
@endif
