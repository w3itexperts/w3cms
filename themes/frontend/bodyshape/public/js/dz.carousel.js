

function handlePostSlider(){
	/*post-swiper*/
	 if(jQuery('.post-swiper-thumb').length > 0){
		var galleryTop = new Swiper('.post-swiper-thumb', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            loop: true,
            loopedSlides: 4
		});
		var galleryThumbs = new Swiper('.post-swiper-thumbs', {
            spaceBetween: 10,
            centeredSlides: true,
            slidesPerView: 4,
            touchRatio: 0.2,
            slideToClickedSlide: true,
            loop: true,
            loopedSlides: 4
		});
		galleryTop.controller.control = galleryThumbs;
		galleryThumbs.controller.control = galleryTop;
	}


	if(jQuery('.post-swiper').length > 0){
		var swiper = new Swiper('.post-swiper', {
			speed: 1500,
			parallax: true,
			slidesPerView: 1,
			spaceBetween: 0,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
				nextEl: '.next-post-swiper-btn',
				prevEl: '.prev-post-swiper-btn',
			}
		});
	}
}

jQuery(document).ready(function() {
    handlePostSlider();
});
/* Document .ready END */


/* Window Load START */
jQuery(window).on('load',function () {
	handlePostSlider();
});
/*  Window Load END */
