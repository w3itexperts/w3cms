@if (isset($args['title']) || isset($args['subtitle']) || isset($args['description']))
<!-- Call To Action -->
<section class="call-action style-1 footer-action">
    <div class="container">
        <div class="inner-content wow fadeInUp" data-wow-delay="0.8s">
            <div class="row justify-content-between align-items-center">
                <div class="text-center text-lg-start col-xl-6 m-lg-b20">
                    <h2 class="title">{!! isset($args['title']) ? $args['title'] : '' !!}</h2>
                    <p>{!! isset($args['description']) ? $args['description'] : '' !!}</p>
                </div>
                <div class="text-center text-lg-end col-xl-6">
                    <form class="dzSubscribe" method="post">
                        @csrf
                        <div class="dzSubscribeMsg"></div>
                        <div class="form-group mb-0">
                            <div class="input-group mb-0"> 
                                <div class="input-skew ">
                                    <input name="dzEmail" required="required" type="email" class="form-control" placeholder="Your Email Address">
                                </div>
                                <div class="input-group-addon">
                                    <button name="submit" value="Submit" type="submit" class="btn btn-secondary btn-lg btn-skew"><span>{{ __('Subscribe Now') }}</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Call To Action -->
@endif