jQuery(document).ready(function($){
    'use strict';

    //News ticker
    $('.breaking-news-items').each(function() {
        $(this).ticker({
            speed       : 0.2,
            controls    : true,
            displayType : 'reveal',
            titleText: $(this).data('title'),
        });
    });
    //Countdown JS
    $('#jannah-countdown').countdown('2021/02/18', function(event) {
        $(this).html(event.strftime('%d days %H:%M:%S'));
      });

    //Menu dropdown overflow fix
    function dropdownOverflowFix(){
        var windowWidth = $(window).width(),
            firstChild = $('.menu > li > .sub-menu'),
            otherChild = $('.menu > li > .sub-menu .sub-menu');

        firstChild.each(function(){
            var thisOffsetRight = $(this).offset().left + $(this).outerWidth();
            if(windowWidth < thisOffsetRight){
                $(this).css({
                    left: 'auto',
                    right: '0'
                });
            }
        });

        otherChild.each(function(){
            var thisOffsetLeft = $(this).offset().left,
                thisOffsetRight = thisOffsetLeft + $(this).outerWidth();

            if(windowWidth < thisOffsetRight){
                $(this).css({
                    left: 'auto',
                    right: '100%'
                });
                $(this).find('.sub-menu').css({
                    left: 'auto',
                    right: '100%'
                })
            }
            if(thisOffsetLeft < 0){
                $(this).css({
                    left: '100%',
                    right: 'auto'
                });
                $(this).find('.sub-menu').css({
                    left: '100%',
                    right: 'auto'
                })
            }
        });
    }

    //Mobile menu toggle
    function mobileMenuToggle(){
        $('.main-nav-wrapper').css('display', 'block');
        $('li.menu-item-has-children').unbind('click');
        $('.menu-primary-container .sub-menu').css('display', 'none');

        $('.mobile-menu-icon').on('click', function(e){
            e.preventDefault();
            $('.main-nav-wrapper').toggleClass( "shown" );
        });

        $('.menu-primary-container li.menu-item-has-children').each(function(){
            $(this).on('click', function(e) {
                $(this).children('.sub-menu').stop().slideToggle();
            });
        });

        $('.menu-primary-container li.menu-item-has-children *').on('click', function(e) {
            e.stopPropagation();
        });

        $('.mobile-search-icon').each(function(){
            $(this).unbind('click');
            $(this).on('click', function(e) {
                e.preventDefault();
                $('.mobile-header-search').fadeToggle();
            });
        });
    }

    // Tab widget
    $('.tabs-container-wrapper').each(function() {
        let that = this;
        let tabHead = $(that).find('.tabs li');

        tabHead.each(function(){
            $(this).on('click', function(e){
                e.preventDefault();
                if(!$(this).hasClass('active')){
                    $(that).find('.tabs li.active').removeClass('active');
                    $(this).addClass('active');
                    $(that).find('.tab-content.active').removeClass('active');
                    $($(this).find('a').attr('href')).addClass('active');
                }
            })
        });
    });

    function jannah_instagram_photos() {
        $('.jannah-instagram-gallery').each(function(){
            $.instagramFeed({
                'username': $(this).data('username'),
                'container': $(this),
                'display_profile': false,
                'display_biography': false,
                'items': $(this).data('items'),
                'items_per_row': $(this).data('row'),
                'margin': 0,
                'styling': false
            });
        });
    }

    $(window).on('load resize orientationchange', function(){
        if($(window).width() > 991){
            dropdownOverflowFix();
        }

        if($(window).width() < 992){
            mobileMenuToggle();
        } else {
            $('.main-nav-wrapper').css('display', 'block');
            $('.menu-primary-container .sub-menu').css('display', 'block');
            $('.mobile-header-search').css('display', 'none');
        }
    });

    $(window).on('load', function(){
        jannah_instagram_photos();
    });
});

jQuery(window).on('load', function(){
    jQuery(window).trigger('resize');
    jQuery('.sticky-sidebar').each(function() {
        var thisDom = jQuery(this).attr('id');
        var thisParent = jQuery(this).data('parent');
        jQuery('#' + thisDom).stickySidebar({
            containerSelector: thisParent,
            innerWrapperSelector: '.sidebar__inner',
            resizeSensor: true,
            topSpacing: 0,
            bottomSpacing: 0
        });
    });
});