/**
	Template Name 	 : BodyShape
	Author			 : DexignZone
	Version			 : 2.0
	File Name	     : custom.js
	Author Portfolio : https://themeforest.net/user/dexignzone/portfolio

	Core script to handle the entire theme and core functions

**/

var BodyShape = function(){
	'use strict';

	var screenWidth = $( window ).width();

	/* Home Search ============ */
	var handleHomeSearch = function() {
		/* top search in header on click function */
		var quikSearch = jQuery("#quik-search-btn");
		var quikSearchRemove = jQuery("#quik-search-remove");

		quikSearch.on('click',function() {
			jQuery('.dz-quik-search').fadeIn(500);
			jQuery('.dz-quik-search').addClass('On');
		});

		quikSearchRemove.on('click',function() {
			jQuery('.dz-quik-search').fadeOut(500);
			jQuery('.dz-quik-search').removeClass('On');
		});
		/* top search in header on click function End*/
	}

	/* Header Height ============ */
	var handleResizeElement = function(){
		var headerTop = 0;
		var headerNav = 0;

		$('.header .sticky-header').removeClass('is-fixed');
		$('.header').removeAttr('style');

		if(jQuery('.header .top-bar').length > 0 &&  screenWidth > 991)
		{
			headerTop = parseInt($('.header .top-bar').outerHeight());
		}

		if(jQuery('.header').length > 0 )
		{
			headerNav = parseInt($('.header').height());
			headerNav =	(headerNav == 0)?parseInt($('.header .main-bar').outerHeight()):headerNav;
		}

		var headerHeight = headerNav + headerTop;

		jQuery('.header').css('height', headerHeight);
	}

	/* Resize Element On Resize ============ */
	var handleResizeElementOnResize = function(){
		var headerTop = 0;
		var headerNav = 0;

		$('.header .sticky-header').removeClass('is-fixed');
		$('.header').removeAttr('style');


		setTimeout(function(){

			if(jQuery('.header .top-bar').length > 0 &&  screenWidth > 991)
			{
				headerTop = parseInt($('.header .top-bar').outerHeight());
			}

			if(jQuery('.header').length > 0 )
			{
				headerNav = parseInt($('.header').height());
				headerNav =	(headerNav == 0)?parseInt($('.header .main-bar').outerHeight()):headerNav;
			}

			var headerHeight = headerNav + headerTop;

			jQuery('.header').css('height', headerHeight);

		}, 500);
    }

	/* Load File ============ */
	var handleDzTheme = function(){
		if(screenWidth <= 991 ){
			jQuery('.navbar-nav > li > a, .sub-menu > li > a').unbind().on('click', function(e){
				if(jQuery(this).parent().hasClass('open'))
				{
					jQuery(this).parent().removeClass('open');
				}
				else{
					jQuery(this).parent().parent().find('li').removeClass('open');
					jQuery(this).parent().addClass('open');
				}
			});
		}

		jQuery('.sidenav-nav .navbar-nav > li > a').next('.sub-menu,.mega-menu').slideUp();
		jQuery('.sidenav-nav .sub-menu > li > a').next('.sub-menu').slideUp();

		jQuery('.sidenav-nav .navbar-nav > li > a, .sidenav-nav .sub-menu > li > a').unbind().on('click', function(e){
			if(jQuery(this).hasClass('dz-open')){
				jQuery(this).removeClass('dz-open');
				jQuery(this).parent('li').children('.sub-menu,.mega-menu').slideUp();
			}else{
				jQuery(this).addClass('dz-open');

				if(jQuery(this).parent('li').children('.sub-menu,.mega-menu').length > 0){

					e.preventDefault();
					jQuery(this).next('.sub-menu,.mega-menu').slideDown();
					jQuery(this).parent('li').siblings('li').find('a').removeClass('dz-open');
					jQuery(this).parent('li').siblings('li').children('.sub-menu,.mega-menu').slideUp();
				}else{
					jQuery(this).next('.sub-menu,.mega-menu').slideUp();
				}
			}
		});
	}

	/* Magnific Popup ============ */
	var handleMagnificPopup = function(){

		if(jQuery('.mfp-gallery').length > 0){
			/* magnificPopup function */
			jQuery('.mfp-gallery').magnificPopup({
				delegate: '.mfp-link',
				type: 'image',
				tLoading: 'Loading image #%curr%...',
				mainClass: 'mfp-img-mobile',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0,1] // Will preload 0 - before current, and 1 after the current image
				},
				image: {
					tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
					titleSrc: function(item) {
						return item.el.attr('title') + '<small></small>';
					}
				}
			});
			/* magnificPopup function end */
		}

		if(jQuery('.mfp-video').length > 0){
			/* magnificPopup for Play video function */
			jQuery('.mfp-video').magnificPopup({
				type: 'iframe',
				iframe: {
					markup: '<div class="mfp-iframe-scaler">'+
							'<div class="mfp-close"></div>'+
							'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
							'<div class="mfp-title">Some caption</div>'+
							'</div>'
				},
				callbacks: {
					markupParse: function(template, values, item) {
						values.title = item.el.attr('title');
					}
				}
			});
		}

		if(jQuery('.popup-youtube, .popup-vimeo, .popup-gmaps').length > 0){
			/* magnificPopup for Play video function end */
			$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
				disableOn: 700,
				type: 'iframe',
				mainClass: 'mfp-fade',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: false
			});
		}
	}

	/* Scroll To Top ============ */
	var handleScrollTop = function (){
		var scrollTop = jQuery("button.scroltop");
		/* page scroll top on click function */
		scrollTop.on('click',function() {
			jQuery("html, body").animate({
				scrollTop: 0
			}, 1000);
			return false;
		})

		jQuery(window).bind("scroll", function() {
			var scroll = jQuery(window).scrollTop();
			if (scroll > 900) {
				jQuery("button.scroltop").fadeIn(1000);
			} else {
				jQuery("button.scroltop").fadeOut(1000);
			}
		});
		/* page scroll top on click function end*/
	}

	/* Header Fixed ============ */
	var handleHeaderFix = function(){
		/* Main navigation fixed on top  when scroll down function custom */
		jQuery(window).on('scroll', function () {
			if(jQuery('.sticky-header').length > 0){
				var menu = jQuery('.sticky-header');
				if ($(window).scrollTop() > menu.offset().top) {
					menu.addClass('is-fixed');
				} else {
					menu.removeClass('is-fixed');
				}
			}
		});
		/* Main navigation fixed on top  when scroll down function custom end*/
	}

	/* Masonry Box ============ */
	var handleMasonryBox = function(){
		/* masonry by  = bootstrap-select.min.js */
		if(jQuery('#masonry, .masonry').length > 0){
			var self = jQuery("#masonry, .masonry");

			if(jQuery('.card-container').length > 0){
				var gutterEnable = self.data('gutter');

				var gutter = (self.data('gutter') === undefined)?0:self.data('gutter');
				gutter = parseInt(gutter);


				var columnWidthValue = (self.attr('data-column-width') === undefined)?'':self.attr('data-column-width');
				if(columnWidthValue != ''){columnWidthValue = parseInt(columnWidthValue);}

				self.imagesLoaded(function () {
					self.masonry({
						//gutter: gutter,
						//columnWidth:columnWidthValue,
						gutterWidth: 15,
						isAnimated: true,
						itemSelector: ".card-container",
						//percentPosition: true
					});

				});
			}
		}
		if(jQuery('.filters').length){
			jQuery(".filters li:first").addClass('active');

			jQuery(".filters").on("click", "li", function() {
				jQuery('.filters li').removeClass('active');
				jQuery(this).addClass('active');

				var filterValue = $(this).attr("data-filter");
				self.isotope({ filter: filterValue });
			});
		}
		/* masonry by  = bootstrap-select.min.js end */
	}

	/* Counter Number ============ */
	var handleCounter = function(){
		if(jQuery('.counter').length){
			jQuery('.counter').counterUp({
				delay: 10,
				time: 3000
			});
		}
	}

	/* Video Popup ============ */
	var handleVideo = function(){
		/* Video responsive function */
		jQuery('iframe[src*="youtube.com"]').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
		jQuery('iframe[src*="vimeo.com"]').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
		/* Video responsive function end */
	}

	/* Gallery Filter ============ */
	var handleFilterMasonary = function(){
		/* gallery filter activation = jquery.mixitup.min.js */
		if (jQuery('#image-gallery-mix').length) {
			jQuery('.gallery-filter').find('li').each(function () {
				$(this).addClass('filter');
			});
			jQuery('#image-gallery-mix').mixItUp();
		};
		if(jQuery('.gallery-filter.masonary').length){
			jQuery('.gallery-filter.masonary').on('click','span', function(){
				var selector = $(this).parent().attr('data-filter');
				jQuery('.gallery-filter.masonary span').parent().removeClass('active');
				jQuery(this).parent().addClass('active');
				jQuery('#image-gallery-isotope').isotope({ filter: selector });
				return false;
			});
		}
		/* gallery filter activation = jquery.mixitup.min.js */
	}

	/* Light Gallery ============ */
	var handleLightGallery = function (){
		if(($('#lightgallery, .lightgallery').length > 0)){
			$('#lightgallery, .lightgallery').lightGallery({
				selector : '.lightimg',
				loop:true,
				download:false,
				thumbnail:true,
				share:false,
				exThumbImage: 'data-exthumbimage'
			});
		}
	}

	/* Box Hover ============ */
	var handleBoxHover = function(){
		jQuery('.box-hover').on('mouseenter',function(){
			var selector = jQuery(this).parent().parent();
			selector.find('.box-hover').removeClass('active');
			jQuery(this).addClass('active');
		});
	}

	/* Current Active Menu ============ */
	var handleCurrentActive = function() {
		for (var nk = window.location,
				o = $("ul.navbar a").filter(function(){
				return this.href == nk;
			})
			.addClass("active").parent().addClass("active");;)
		{
		if (!o.is("li")) break;
			o = o.parent().addClass("show").parent('li').addClass("active");
		}
	}

	/* Select Picker ============ */
	var handleSelectpicker = function(){
		if(jQuery('.default-select').length > 0 ){
			jQuery('.default-select').selectpicker();
		}
	}

	/* Icon Dropdowm ============ */
	var handleIconDropdowm = function(){
		jQuery(".icon-dropdown").on('click', function(){
			if($(this).hasClass("show")){
				$(this).removeClass("show");
			}else {
				jQuery(".icon-dropdown").removeClass("show");
				$(this).addClass("show");
			}
	  	});
	}

	/* Perfect Scrollbar ============ */
	var handlePerfectScrollbar = function() {
		if(jQuery('.deznav-scroll').length > 0){
			const qs = new PerfectScrollbar('.deznav-scroll');
			qs.isRtl = false;
		}
	}

	/* Wow Animation ============ */
	var handleWowAnimation = function(){
		if($('.wow').length > 0){
			var wow = new WOW({
				boxClass:     'wow',      // Animated element css class (default is wow)
				animateClass: 'animated', // Animation css class (default is animated)
				offset:       0,          // Distance to the element when triggering the animation (default is 0)
				mobile:       false       // Trigger animations on mobile devices (true is default)
			});
			setTimeout(function(){
				wow.init();
			}, 1520);
		}
	}

	/* Countdown Timer ============ */
	var handleFinalCountDown = function(){
		var launchDate = jQuery('.countdown-timer').data('date');

		if(launchDate != undefined && launchDate != '')
		{
			WebsiteLaunchDate = launchDate;
		}

		if(jQuery('.countdown-timer').length > 0 )
		{
			var startTime = new Date(); // Put your website start time here
			startTime = startTime.getTime();

			var currentTime = new Date();
			currentTime = currentTime.getTime();

			var endTime = new Date(WebsiteLaunchDate); // Put your website end time here
			endTime = endTime.getTime();

			$('.countdown-timer').final_countdown({

				'start': (startTime/1000),
				'end': (endTime/1000),
				'now': (currentTime/1000),
				selectors: {
					value_seconds:'.clock-seconds .val',
					canvas_seconds:'canvas-seconds',
					value_minutes:'.clock-minutes .val',
					canvas_minutes:'canvas-minutes',
					value_hours:'.clock-hours .val',
					canvas_hours:'canvas-hours',
					value_days:'.clock-days .val',
					canvas_days:'canvas-days'
				},
				seconds: {
					borderColor:$('.type-seconds').attr('data-border-color'),
					borderWidth:'5',
				},
				minutes: {
					borderColor:$('.type-minutes').attr('data-border-color'),
					borderWidth:'5'
				},
				hours: {
					borderColor:$('.type-hours').attr('data-border-color'),
					borderWidth:'5'
				},
				days: {
					borderColor:$('.type-days').attr('data-border-color'),
					borderWidth:'5'
				}
			}, function() {
				jQuery.ajax({
					type: 'POST',
					url: akcel_js_data.admin_ajax_url,
					data: "action=change_theme_status_ajax&security="+akcel_js_data.ajax_security_nonce,
					success: function(data) {
						location.reload();
					}
				});
			});
		}
	}

  	var WebsiteLaunchDate = new Date();
	var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	WebsiteLaunchDate.setMonth(WebsiteLaunchDate.getMonth() + 1);
	WebsiteLaunchDate =  WebsiteLaunchDate.getDate() + " " + monthNames[WebsiteLaunchDate.getMonth()] + " " + WebsiteLaunchDate.getFullYear();


	/* BMI Calculator ============ */
	var handleBmiCalculator = function(){
		if(jQuery('#BmiCalculator').length > 0 ){
			jQuery("#BmiCalculator").on('submit', function() {
				event.preventDefault();
				var age = jQuery("#age").val();
				var height = jQuery("#height").val();
				var weight = jQuery("#weight").val();
				var gender = jQuery("#gender").val();
				var form = jQuery(this);

				if(age == '' || height == '' || weight == '' || gender == '' || gender == false){
					alert("All fields are required!");
					return false;
				}

				form[0].reset();
				var bmi = Number(weight)/(Number(height)/100*Number(height)/100);

				var result = '';
				if(bmi < 18.5) {
					result = 'Underweight';
				} else if(18.5 <= bmi && bmi <= 24.9) {
					result = 'Healthy';
				} else if(25 <= bmi && bmi <= 29.9) {
					result = 'Overweight';
				} else if(30 <= bmi && bmi <= 34.9) {
					result = 'Obese';
				} else if(35 <= bmi) {
					result = 'Extremely obese';
				}

				jQuery('.dzFormBmi').html('<div class="dzFormInner"><h4 class="title text-white">'+result+'</h4><h5 class="bmi-result text-primary m-b0">BMI: '+parseFloat(bmi).toFixed(2)+'</h5></div>');
			});
		}
	}

	/* datetimepicker ============ */
	var datetimepicker = function (){
		if(($('#datetimepicker').length > 0)){
			$('#datetimepicker').datetimepicker();
		}
	}

	var handleImageTooltip = function(){
		$('.image-tooltip-effect').hover(function(){

			var title = $(this).find('.title').text();
			var subTitle = $(this).find('.sub-title').text();
			$(this).data('tipText', title);
			 $('body').append("<div class='image-tooltip'>"+"<h4 class='title'>" + title + "</h4>"+"<h6 class='sub-title'>"+ subTitle +"</h6>"+"</div>");

			var imageTooltipWidth = $(this).find('.dz-info').width() + 40;

			$('.image-tooltip').animate({width: imageTooltipWidth}, 500, "linear");

		},
		function(){
			// Hover out code
			$(this).find('span', $(this).data('tipText'));
			$('.image-tooltip').remove();

		}).mousemove(function(e) {
			var mousex = e.pageX + 20; //Get X coordinates
			var mousey = e.pageY + 10; //Get Y coordinates
			$('.image-tooltip').css({ top: mousey, left: mousex })
			if(mousex + $('.image-tooltip').width() + 60 > screen.width){
				$('.image-tooltip').css({ top: mousey, left: mousex - $('.image-tooltip').width() - 60})

			}
		});
	}

	// handleImageTooltip2
	var handleImageTooltip2 = function(){
		if(screenWidth > 991){
			$('.image-tooltip-effect-2').hover(function(){
				var title = $(this).find('.title').attr('src');
				$(this).data('tipText', title);
				 $('body').append("<div class='image-tooltip style-2'>"+`<img src="${title}" class='title'>`+"</div>");

				var imageTooltipWidth = $(this).find('.dz-info').width() + 40;
				console.log(imageTooltipWidth);
				$('.image-tooltip').width(300);
			},
			function(){
				// Hover out code
				$(this).find('span', $(this).data('tipText'));
				$('.image-tooltip').remove();

			}).mousemove(function(e) {
				var mousex = e.pageX + 20; //Get X coordinates
				var mousey = e.pageY + 10; //Get Y coordinates
				$('.image-tooltip').css({ top: mousey, left: mousex })
				if(mousex + $('.image-tooltip').width() + 60 > screen.width){
					$('.image-tooltip').css({ top: mousey, left: mousex - $('.image-tooltip').width() - 60})
				}
			});
		}
	}

	/* Pointer Effect ============ */
	var handlePointerEffect = function(){
		/*
			pointer.js was created by OwL for use on websites,
			and can be found at https://seattleowl.com/pointer.
		*/

		const pointer = document.createElement("div")
		pointer.id = "pointer-dot"
		const ring = document.createElement("div")
		ring.id = "pointer-ring"
		document.body.insertBefore(pointer, document.body.children[0])
		document.body.insertBefore(ring, document.body.children[0])

		let mouseX = -100
		let mouseY = -100
		let ringX = -100
		let ringY = -100
		let isHover = false
		let mouseDown = false
		const init_pointer = (options) => {

			window.onmousemove = (mouse) => {
				mouseX = (mouse.clientX != undefined)?mouse.clientX:-100;
				mouseY = (mouse.clientY != undefined)?mouse.clientY:-100;
			}

			window.onmousedown = (mouse) => {
				mouseDown = true
			}

			window.onmouseup = (mouse) => {
				mouseDown = false
			}

			const trace = (a, b, n) => {
				return (1 - n) * a + n * b;
			}
			window["trace"] = trace

			const getOption = (option) => {
				let defaultObj = {
					pointerColor: "#750c7e",
					ringSize: 15,
					ringClickSize: (options["ringSize"] || 15) - 5,
				}
				if (options[option] == undefined) {
					return defaultObj[option]
				} else {
					return options[option]
				}
			}

			const render = () => {
				if(mouseX != undefined){
					ringX = trace(ringX, mouseX, 0.2)
					ringY = trace(ringY, mouseY, 0.2)

					if (document.querySelector(".p-action-click:hover")) {
						pointer.style.borderColor = getOption("pointerColor")
						isHover = true
					} else {
						pointer.style.borderColor = "white"
						isHover = false
					}
					ring.style.borderColor = getOption("pointerColor")
					if (mouseDown) {
						ring.style.padding = getOption("ringClickSize") + "px"
					} else {
						ring.style.padding = getOption("ringSize") + "px"
					}




					pointer.style.transform = `translate(${mouseX}px, ${mouseY}px)`

					ring.style.transform = `translate(${ringX - (mouseDown ? getOption("ringClickSize") : getOption("ringSize"))}px, ${ringY - (mouseDown ? getOption("ringClickSize") : getOption("ringSize"))}px)`

					requestAnimationFrame(render)
				}
			}
			requestAnimationFrame(render)
		}

		jQuery('a').on('mousemove',function(e){
			jQuery('#pointer-ring').addClass('active');
		});

		jQuery('a').on('mouseleave',function(e){
			jQuery('#pointer-ring').removeClass('active');
		});

		init_pointer({});
	}

	/* Twenty Twenty ============ */
	var handleTwentytwenty = function(){
		if(($('.twentytwenty-container').length > 0)){
			$(".twentytwenty-container[data-orientation!='vertical']").twentytwenty({
				default_offset_pct: 0.5,
			});
			$(".twentytwenty-container[data-orientation='vertical']").twentytwenty({
				default_offset_pct: 0.3,
				orientation: 'vertical',
			});
		}
	}

	/* Function ============ */
	return {
		init:function(){
			datetimepicker();
			handleHomeSearch();
			handleBoxHover();
			handleDzTheme();
			handleMagnificPopup();
			handleScrollTop();
			handleHeaderFix();
			handleSelectpicker();
			handleVideo();
			handleFilterMasonary();
            setTimeout(()=>{
                handleFinalCountDown();
            }, 500)
			handleLightGallery();
			handleIconDropdowm();
			handleCurrentActive();
			handlePerfectScrollbar();
			handleWowAnimation();
			handleBmiCalculator();
			handleImageTooltip();
			handleImageTooltip2()
			handlePointerEffect()
		},

		load:function(){
			handleCounter();
			handleMasonryBox();
			handleDzTheme();
			handleTwentytwenty();
		},

		resize:function(){
			screenWidth = $(window).width();
			handleFinalCountDown();
			handleDzTheme();
			handleImageTooltip2()
		}
	}

}();

/* Document.ready Start */
jQuery(document).ready(function() {
    BodyShape.init();

	$('a[data-bs-toggle="tab"]').click(function(){
		// todo remove snippet on bootstrap v5
		$('a[data-bs-toggle="tab"]').click(function() {
			$($(this).attr('href')).show().addClass('show active').siblings().hide();
		})
	});

	jQuery('.navicon').on('click',function(){
		$(this).toggleClass('open');
	});

});
/* Document.ready END */

/* Window Load START */
jQuery(window).on('load',function () {
	BodyShape.load();

	setTimeout(function(){
		jQuery('#loading-area').addClass('active');
		jQuery('#loading-area').fadeOut();
	}, 1500);
	setTimeout(function(){
		jQuery('#loading-area').addClass('show');
	}, 500);


});
/*  Window Load END */

/* Window Resize START */
jQuery(window).on('resize',function () {
	BodyShape.resize();
});
/*  Window Resize END */

