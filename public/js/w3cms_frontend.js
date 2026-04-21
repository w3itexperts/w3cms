(function ($) {
    "use strict";

    var w3cms = function () {

		var handleFinalCountDown = function(){
			if ($(".countdown").length > 0) {

				/* Website Launch Date */
				var WebsiteLaunchDate = new Date();
				var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
				WebsiteLaunchDate.setMonth(WebsiteLaunchDate.getMonth() + 1);
				var dateParts = $('.countdown').attr('data-date').split('-');
				var WebsiteLaunchDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
				WebsiteLaunchDate = WebsiteLaunchDate.getDate() + " " + monthNames[WebsiteLaunchDate.getMonth()] + " " + WebsiteLaunchDate.getFullYear();
				/* Website Launch Date END */

				var commingSoonDate = new Date(WebsiteLaunchDate).getTime();

				var x = setInterval(function () {
					clockCounter();
				}, 1000);

				function clockCounter() {
					var currentTime = new Date().getTime();
					var clockTime = commingSoonDate - currentTime;

					// Time calculations for days, hours, minutes and seconds
					var days = Math.floor(clockTime / (1000 * 60 * 60 * 24));
					var hours = Math.floor((clockTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					var minutes = Math.floor((clockTime % (1000 * 60 * 60)) / (1000 * 60));
					var seconds = Math.floor((clockTime % (1000 * 60)) / 1000);

					var remainDays = (days.toString().length == 1) ? '0' + days : days;
					var remainHour = (hours.toString().length == 1) ? '0' + hours : hours;
					var remainMin = (minutes.toString().length == 1) ? '0' + minutes : minutes;
					var remainSeconds = (seconds.toString().length == 1) ? '0' + seconds : seconds;

					jQuery('#day').text(remainDays);
					jQuery('#hour').text(remainHour);
					jQuery('#min').text(remainMin);
					jQuery('#second').text(remainSeconds);

					var rotateNum = 6 * seconds;

					$('.round').css({ 'transform': 'rotate(' + rotateNum + 'deg)' });
					$('.round').css({ '-webkit-transform': 'rotate(' + rotateNum + 'deg)' });
					$('.round').css({ '-o-transform': 'rotate(' + rotateNum + 'deg)' });
					$('.round').css({ '-moz-transform': 'rotate(' + rotateNum + 'deg)' });
					$('.round').css({ '-ms-transform': 'rotate(' + rotateNum + 'deg)' });

					// If the count down is over, write some text 
					if (clockTime < 0) {
						clearInterval(x);
						jQuery("#day, #hour, #min, #second").html("EXPIRED");
					}
				}
			}
		}

        /* Handle Support ============ */
        var handleCommentReply = function () {
            jQuery('.w3-comment-reply').on('click', function (event) {
                event.preventDefault();

                var parent_id = $(this).data("commentid")
                var blog_id = $(this).data('postid');
                var replyto = $(this).data('replyto');
                var parent = $(this).parents('.comment .comment-body:first');

                $("#comment_parent").val(parent_id);
                $('#commentform').trigger("reset");
                $("#cancel-comment-reply").removeClass('d-none');
                $("#reply-title").parent().removeClass('d-none').addClass('d-block');
                $("#reply-title").html(replyto);
                $("#ReplyFormContainer").insertAfter(parent);

            });

            jQuery('#cancel-comment-reply').on('click', function (event) {

                event.preventDefault();

                $("#comment_parent").val(0);
                $("#reply-title").empty();
                $("#reply-title").parent().removeClass('d-block').addClass('d-none');
                $("#cancel-comment-reply").addClass('d-none');
                $("#ReplyFormContainer").appendTo('#comments-div');
            });
        }

        // handleAjaxLoadMore
        var handleAjaxLoadMore = function() {
			jQuery('.ajax-load-more').on('click', function(e) {
				e.preventDefault();

				var thisObj = jQuery(this);
				var formId = thisObj.data('form-id');

				var data_current_page = $('#'+formId).find('input[name="page"]').val();
				var ajax_container = $('#'+formId).find('input[name="ajax_container"]').val();
				var data = $('#'+formId).serialize();

				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'Post',
					url: baseUrl+'/ajax-get-data',
					data: data,
					success : function(response)
					{
						if (response.html) {
							jQuery('#' + ajax_container).append(response.html);

					        // Check if there are more pages to load
					        if (response.has_more_pages) {

								data_current_page++;
					            $('#'+formId).find('input[name="page"]').val(data_current_page);

					        } else {
					            // No more posts to load
					            $(thisObj).text('No More Posts');
					            $(thisObj).prop('disabled', true).addClass('disabled');
					        }

                            var self = jQuery('#masonry, .masonry');
                            if(self.length)
                            {
                                if(jQuery('.card-container').length)
                                {
                                    self.imagesLoaded(function () {
                                        self.masonry({
                                            gutterWidth: 15,
                                            isAnimated: true,
                                            itemSelector: ".card-container"
                                        });
                                    });
                                }
                                self.masonry('reloadItems');
                            }
						}
						else {
				          	alert('Failed to load more posts.');
				        }
					}
				});
			});
		}

        /* Function ============ */
        return {
            init: function () {
                handleFinalCountDown();
                handleCommentReply();
                handleAjaxLoadMore();
            },
        }
    }();

    /* Document.ready Start */
    jQuery(document).ready(function () {
        w3cms.init();
    });

})(jQuery);