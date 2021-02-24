(function ($) {
	var ua = window.navigator.userAgent;
	var isIE = /MSIE|Trident/.test(ua);

	if ( !isIE ) {
		//IE specific code goes here
		"use strict";
	}

	/*** Sticky header */
	$(window).scroll(function(){
		if($("body").scrollTop() > 0 || $("html").scrollTop() > 0) {
			$(".header").addClass("stop");
		} else {
			$(".header").removeClass("stop");
		}
	});

	/*** Sidr Menu */
	$('.navbar-toggle').sidr({
     	name: 'sidr-main',
      	side: 'right',
      	source: '#sidr',
      	displace: false,
      	renaming: false,
    });

    $('.navbar-toggle.in').on('click', function(){
		$.sidr('close', 'sidr-main');
	});

	// $(".navbar-toggle").click(function() {
	// 	$(this).toggleClass('in');
	// });

	$('.scrollDown').click(function() {
        var target = $('#primary');
        var space = $(this).data('space');

        if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top - space
            }, 1000);
        }
    });

	/*** Header height = gutter height */
	function setGutterHeight(){
		var header = document.querySelector('.header'),
			  gutter = document.querySelector('.header_gutter');
		if (gutter) {
			gutter.style.height = header.offsetHeight + 'px';
		}
	}
	window.onload = setGutterHeight;
	window.onresize = setGutterHeight;

	/*** rellax */
	var rellax = new Rellax('.rellax', {
		speed: -2,
		center: false,
		wrapper: null,
		round: true,
		vertical: true,
		horizontal: false
	});

     /*** Number Counter */
    $('.counter').counterUp({
        delay: 10,
        time: 2000
    });

	$('.fbp-slider').slick({
		speed: 300,
		dots: true,
		arrows: true,
		infinite: true,
		slidesToShow: 1,
		appendArrows: $('.fbp-slider-control'),
	});

	// Animation
	$('.fbp-slider').on('init', function(e, slick) {
		var $firstAnimatingElements = $('.slider-item.slick-active').find('[data-animation]');
		doAnimations($firstAnimatingElements);    
	});

	$('.fbp-slider').on('beforeChange', function(e, slick, currentSlide, nextSlide) {
		var $animatingElements = $('.slider-item[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
		doAnimations($animatingElements); 
	});

	function doAnimations(elements) {
		var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
		elements.each(function() {
			var $this = $(this);
			var $animationDelay = $this.data('delay');
			var $animationType = 'animated ' + $this.data('animation');
			$this.css({
				'animation-delay': $animationDelay,
				'-webkit-animation-delay': $animationDelay
			});

			$this.addClass($animationType).one(animationEndEvents, function() {
				$this.removeClass($animationType);
			});
		});
	};

    /*** Home Page Slider */
    var time = 5;
    var $bar,
        $slick,
        isPause,
        tick,
        percentTime;
    $testiSlider = $(".testimonial-slider");
    $bar = $('.slider-progress-bar .progress');

    $testiSlider.slick({
        dots: true,
        fade: false,
        arrows: true,
        slidesToShow: 1,
        slidesToScroll: 1,
    });

    $testiSlider.on({
        mouseenter: function() {
            isPause = true;
        },
        mouseleave: function() {
            isPause = false;
        }
    });

    function startProgressbar() {
        resetProgressbar();
        percentTime = 0;
        isPause = false;
        tick = setInterval(interval, 10);
    }

    function interval() {
        if(isPause === false) {
            percentTime += 1 / (time+0.1);
            $bar.css({
                width: percentTime+"%"
            });
            if(percentTime >= 100) {
                $testiSlider.slick('slickNext');
                startProgressbar();
            }
        }
    }

    function resetProgressbar() {
        $bar.css({
            width: 0+'%' 
        });
        clearTimeout(tick);
    }
      
    startProgressbar();

	/*** SVG Separator */
    $('img.svg').each(function(){
        var $img = $(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');
        var dataColor = $img.attr('data-color');

        $.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = $(data).find('svg');

            // Add replaced image's ID to the new SVG
            if(typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }

            // Add replaced image's classes to the new SVG
            if(typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass+' replaced-svg');
            }

            // Add replaced image's classes to the new SVG
            if(typeof dataColor !== 'undefined') {
                $($svg[0].firstElementChild).css({ stroke :  dataColor });
            }
    
            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');
            
            // Check if the viewport is set, else we gonna set it if we can.
            if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
            }
    
            // Replace image with new SVG
            $img.replaceWith($svg);
    
        }, 'xml');
    });

    /*** Generated by CoffeeScript 1.9.2 */
    function stickyKit() {
        var reset_scroll;

        $(function() {
            return $("[data-sticky_column]").stick_in_parent({
                parent: "[data-sticky_parent]",
                offset_top: 120,
                bottoming: true,
            });
        });

        reset_scroll = function() {
            var scroller;
            scroller = $("body,html");
            scroller.stop(true);

            if ($(window).scrollTop() !== 0) {
                scroller.animate({
                    scrollTop: 0
                }, "fast");
            }
            return scroller;
        };

        window.scroll_it = function() {
            var max;
            max = $(document).height() - $(window).height();

            return reset_scroll().animate({
                scrollTop: max
            }, max * 3).delay(100).animate({
                scrollTop: 0
            }, max * 3);
        };

        window.scroll_it_wobble = function() {
            var max, third;
            max = $(document).height() - $(window).height();
            third = Math.floor(max / 3);

            return reset_scroll().animate({
                scrollTop: third * 2
            }, max * 3).delay(100).animate({
                scrollTop: third
            }, max * 3).delay(100).animate({
                scrollTop: max
            }, max * 3).delay(100).animate({
                scrollTop: 0
            }, max * 3);
        };

        $(window).on("load", (function(_this) {
            return function(e) {
                return $(document.body).trigger("sticky_kit:recalc");
            };
        })(this));

        $(window).on("resize", (function(_this) {
            return function(e) {
                return $(document.body).trigger("sticky_kit:recalc");
            };
        })(this));
    }

    var window_width = $(window).width();

    if (window_width < 992) {
        $(document.body).trigger("sticky_kit:detach");
    } else {
        stickyKit();
    }

    $( window ).resize(function() {
        window_width = $( window ).width();
        if (window_width < 992) {
            $(document.body).trigger("sticky_kit:detach");
        } else {
            stickyKit();
        }
    });

    $('.popup-video').magnificPopup({
        type: 'iframe',
        preloader: false,
        fixedBgPos: true,
        removalDelay: 500,
        fixedContentPos: true,
        callbacks: {
            beforeOpen: function() {
                console.log(this.st.iframe.markup);
                this.st.iframe.markup = this.st.iframe.markup.replace('mfp-iframe-scaler', 'mfp-iframe-scaler mfp-with-anim');
                this.st.mainClass = this.st.el.attr('data-effect');
            }
        },
    });

    $(".footer-menu li.spendebt a, .page-header-about .spendebt").each(function() {
        var text = $(this).text();
        text = text.replace("Spendebt", "<span>Spen</span><span>debt</span>");
        $(this).html(text);
    });

}(jQuery));