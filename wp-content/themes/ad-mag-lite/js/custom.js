/*==

Copyright (c) Kopa Theme Premium Wordpress Theme

==*/


/**
 *  1.  top Menu
    2.  Main Menu
    3.  Search box
    4.  Accordion
    5.  Toggle
    6.  Owl Carousel
    7.  Validate Form
    8.  Breadking News
    9.
    10. Scroll to top
    11. Masonry
    12. Bootstrap Slider
    13. Accordion Slider
    14. Enquire
    15. Fix css ie8
    16. Match height

 *-----------------------------------------------------------------
 **/
 

"use strict";


jQuery(document).ready(function(){

var ad_mag_lite_variable = {
    "contact": {
        "address": "Lorem ipsum dolor sit amet, consectetur adipiscing elit",
        "marker": "/url image"
    },
    "i18n": {
        "VIEW": "View",
        "VIEWS": "Views",
        "validate": {
            "form": {
                "SUBMIT": "Submit",
                "SENDING": "Sending..."
            },
            "name": {
                "REQUIRED": "Please enter your name",
                "MINLENGTH": "At least {0} characters required"
            },
            "email": {
                "REQUIRED": "Please enter your email",
                "EMAIL": "Please enter a valid email"
            },
            "url": {
                "REQUIRED": "Please enter your url",
                "URL": "Please enter a valid url"
            },
            "message": {
                "REQUIRED": "Please enter a message",
                "MINLENGTH": "At least {0} characters required"
            }
        },
        "tweets": {
            "failed": "Sorry, twitter is currently unavailable for this user.",
            "loading": "Loading tweets..."
        }
    },
    "url": {
        "template_directory_uri":""
    }
};

var map;



/* =========================================================
1. top Menu
============================================================ */

Modernizr.load([
  {
    load: ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/superfish.min.js',
    complete: function () {

        //Main menu
        jQuery('.top-menu').superfish({
        });
    }
  }
]);


/* =========================================================
2. Main Menu
============================================================ */

Modernizr.load([
  {
    load: ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/superfish.min.js',
    complete: function () {
        
        var r_ul = jQuery('.kopa-main-nav .sf-menu');
        r_ul.superfish({
            speed: "fast",
            delay: "100"
        });

        

    }
  }
]);


/* ============================================
3. Mobile-menu
=============================================== */

    Modernizr.load([{
        load: [ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.navgoco.min.js'],
        complete: function () {

            jQuery(".top-menu-mobile").navgoco({
                accordion: true
            });
            jQuery(".top-nav-mobile > .pull").click(function () {
                jQuery(this).closest(".top-nav-mobile").find(".top-menu-mobile").slideToggle("slow");
            });
            
            
            
            jQuery(".main-nav-mobile > .pull").click(function () {
                jQuery(this).closest(".main-nav-mobile").find(".main-menu-mobile").slideToggle("slow");
            });
            jQuery(".main-menu-mobile").navgoco({
                accordion: true
            });

            jQuery(".main-menu-mobile").find(".sf-mega").removeClass("sf-mega").addClass("sf-mega-mobile");
            jQuery(".main-menu-mobile").find(".sf-mega-section").removeClass("sf-mega-section").addClass("sf-mega-section-mobile");
            jQuery(".caret").removeClass("caret");

            jQuery(".bottom-nav-mobile > .pull").click(function () {
                jQuery(this).closest(".bottom-nav-mobile").find(".main-menu-mobile").slideToggle("slow");
            });

        }
    }]);




/* =========================================================
4. Accordion
============================================================ */

    var panel_titles = jQuery('.kopa-accordion .panel-title a');
    panel_titles.addClass("collapsed");
    jQuery('.panel-heading.active').find(panel_titles).removeClass("collapsed");
    panel_titles.click(function(){
        jQuery(this).closest('.kopa-accordion').find('.panel-heading').removeClass('active');
        var pn_heading = jQuery(this).parents('.panel-heading');
        if (jQuery(this).hasClass('collapsed')) {
            pn_heading.addClass('active');
        } else {
            pn_heading.removeClass('active');
        }
    });



 /* =========================================================
5. Toggle
============================================================ */
 
    jQuery('.kopa-toggle .panel-group .collapse').collapse({
        toggle: false
    });  
    var panel_titles_2 = jQuery('.kopa-toggle .panel-title a');
    panel_titles_2.click(function(){
        var parent = jQuery(this).closest('.panel-heading');
        if (parent.hasClass('active')) {
            parent.removeClass('active');
        } else {
            parent.addClass('active');
        }
    });

 /* =========================================================
6. Owl Carousel
============================================================ */

    Modernizr.load([{
        load: [ ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/owl.carousel.min.js'],
        complete: function () {

            var owl1 = jQuery(".owl-carousel-1");
            owl1.owlCarousel({
                items: 4,
                pagination: true,
                slideSpeed: 600,
                navigationText: false,
                navigation: false,
                beforeInit: function(){
                    owl1.find(".item:even").addClass("bgb");
                }
            });

            var owl2 = jQuery(".owl-carousel-2");
            owl2.owlCarousel({
                items: 3,
                itemsDesktop: [1160,3],
                itemsDesktopSmall : [979,2],
                itemsTabletSmall: [639,1],
                pagination: false,
                slideSpeed: 600,
                navigationText: false,
                navigation: true
            });
            owl2.find(".owl-controls").addClass("style1");

            var owl3 = jQuery(".owl-carousel-3");
            owl3.owlCarousel({
                items: 2,
                itemsDesktop: [1160,2],
                pagination: false,
                slideSpeed: 600,
                navigationText: false,
                navigation: true
            });
            owl3.find(".owl-controls").addClass("style1");

            var owl4 = jQuery(".owl-carousel-4");
            owl4.owlCarousel({
                items: 4,
                pagination: false,
                slideSpeed: 600,
                navigationText: false,
                navigation: true
            });
            owl4.find(".owl-controls").addClass("style1");

            var owl5 = jQuery(".owl-carousel-5");
            owl5.owlCarousel({
                items: 3,
                itemsDesktop: [1160,3],
                itemsDesktopSmall : [979,2],
                itemsTabletSmall: [639,1],
                pagination: false,
                slideSpeed: 600,
                navigationText: false,
                navigation: true
            });
            owl5.find(".owl-controls").addClass("style2");

            var owl6 = jQuery(".owl-carousel-6");
            owl6.owlCarousel({
                items: 3,
                itemsDesktop: [1160,3],
                itemsTablet: [799,3],
                itemsTabletSmall: [639,2],
                pagination: false,
                slideSpeed: 600,
                autoPlay: true,
                stopOnHover: true,
                navigationText: false,
                navigation: true
            });

            var owl7 = jQuery(".owl-carousel-7");
            owl7.owlCarousel({
                singleItem: true,
                pagination: true,
                slideSpeed: 600,
                navigationText: false,
                navigation: true
            });
            owl7.find(".owl-controls").addClass("style3");


        }   
    }]);


/* =========================================================
7. Validate Form
============================================================ */

    if (jQuery('.contact-form').length > 0) {
        Modernizr.load([
          {
            load:[ ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.form.min.js', ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.validate.min.js'],
            complete: function () {
                jQuery('.contact-form').validate({
                    // Add requirements to each of the fields
                    rules: {
                        name: {
                            required: true,
                            minlength: 8
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        message: {
                            required: true,
                            minlength: 10
                        }
                    },
                    // Specify what error messages to display
                    // when the user does something horrid
                    messages: {
                        name: {
                            required: "Please enter your name.",
                            minlength: jQuery.format("At least {0} characters required.")
                        },
                        email: {
                            required: "Please enter your email.",
                            email: "Please enter a valid email."
                        },
                        message: {
                            required: "Please enter a message.",
                            minlength: jQuery.format("At least {0} characters required.")
                        }
                    },
                    // Use Ajax to send everything to processForm.php
                    submitHandler: function (form) {
                    jQuery(".contact-form .input-submit").attr("value", ad_mag_lite_custom_front_localization.validate.form.sending);
                    jQuery(form).ajaxSubmit({
                        success: function (data) {
                            jQuery("#response").html(data);
                            jQuery(".contact-form .input-submit").attr("value", ad_mag_lite_custom_front_localization.validate.form.submit);
                        }
                    });
                    return false;
                }
                });
            }
          }
        ]);
    };

    /*-- comment form --*/

    if (jQuery('#comments-form').length > 0) {
        Modernizr.load([
          {
            load:[ ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.form.min.js', ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.validate.min.js'],
            complete: function () {
                jQuery('#comments-form').validate({
                    // Add requirements to each of the fields
                    rules: {
                        author: {
                            required: true,
                            minlength: 8
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        comment: {
                            required: true,
                            minlength: 15
                        }
                    },
                    // Specify what error messages to display
                    // when the user does something horrid
                    messages: {
                        author: {
                            required: "Please enter your name.",
                            minlength: jQuery.format("At least {0} characters required.")
                        },
                        email: {
                            required: "Please enter your email.",
                            email: "Please enter a valid email."
                        },
                        comment: {
                            required: "Please enter a message.",
                            minlength: jQuery.format("At least {0} characters required.")
                        }
                    }
                });
            }
          }
        ]);
    };

/* =========================================================
8. Breadking News
============================================================ */

Modernizr.load([
  {
    load: [ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.ticker.js',ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/site.js'],
    complete: function () {

        jQuery('#js-news').ticker({
            titleText: 'Breaking' 
        });
    }
  }
]);

  /* =========================================================
10. Scroll to top
============================================================ */

    jQuery('.scrollup').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });

 /* =========================================================
11. Masonry
============================================================ */

    Modernizr.load([{
        load: [ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/masonry.pkgd.min.js',   ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/imagesloaded.js'],
        complete: function () {

            var jQuerymasonry1 = jQuery('.kopa-masonry-widget').find('.kopa-masonry-wrap');
            imagesLoaded(jQuerymasonry1, function () {
                jQuerymasonry1.masonry({
                    columnWidth: 1,
                    itemSelector: '.ms-item1'
                });
                jQuerymasonry1.masonry('bindResize')
            });

            var jQuerymasonry2 = jQuery('.kopa-masonry-2-widget').find('.kopa-masonry-wrap');
            imagesLoaded(jQuerymasonry2, function () {
                jQuerymasonry2.masonry({
                    columnWidth: 1,
                    itemSelector: '.ms-item2'
                });
                jQuerymasonry2.masonry('bindResize')
            });

            var jQuerymasonry3 = jQuery('.kopa-masonry-3-widget').find('.kopa-masonry-wrap');
            imagesLoaded(jQuerymasonry3, function () {
                jQuerymasonry3.masonry({
                    columnWidth: 1,
                    itemSelector: '.ms-item3'
                });
                jQuerymasonry3.masonry('bindResize')
            });

            var jQuerymasonry4 = jQuery('.kopa-masonry-4-widget').find('.kopa-masonry-wrap');
            imagesLoaded(jQuerymasonry4, function () {
                jQuerymasonry4.masonry({
                    columnWidth: 1,
                    itemSelector: '.ms-item4'
                });
                jQuerymasonry4.masonry('bindResize')
            });

            var jQuerymasonry5 = jQuery('.kopa-masonry-5-widget').find('.kopa-masonry-wrap');
            imagesLoaded(jQuerymasonry5, function () {
                jQuerymasonry5.masonry({
                    columnWidth: 1,
                    itemSelector: '.ms-item5'
                });
                jQuerymasonry5.masonry('bindResize')
            });

            var jQuerymasonry6 = jQuery('.kopa-masonry-6-widget').find('.kopa-masonry-wrap');
            imagesLoaded(jQuerymasonry6, function () {
                jQuerymasonry6.masonry({
                    columnWidth: 1,
                    itemSelector: '.ms-item6'
                });
                jQuerymasonry6.masonry('bindResize')
            });

            var jQuerymasonry7 = jQuery('.kopa-masonry-7-widget').find('.kopa-masonry-wrap');
            imagesLoaded(jQuerymasonry7, function () {
                jQuerymasonry7.masonry({
                    columnWidth: 1,
                    itemSelector: '.ms-item7'
                });
                jQuerymasonry7.masonry('bindResize')
            });

            var jQuerymasonry8 = jQuery('.kopa-masonry-8-widget').find('.kopa-masonry-wrap');
            imagesLoaded(jQuerymasonry8, function () {
                jQuerymasonry8.masonry({
                    columnWidth: 1,
                    itemSelector: '.ms-item8'
                });
                jQuerymasonry8.masonry('bindResize')
            });
        }   
    }]);



/* ============================================
12. Bootstrap Slider
=============================================== */

if (jQuery('.kopa-slider-ip').length > 0) {

    Modernizr.load([{
        load: [ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/bootstrap-slider.min.js'],
        complete: function () {
            jQuery('.kopa-slider-ip').slider({
                tooltip: "show"
            })
            .on('slideStop', function(){
                var value = jQuery('.tooltip-inner').text();
                jQuery.ajax({
                    type: 'POST',
                    url: ad_mag_lite_front_variable.ajax.url,
                    dataType: 'json',
                    async: true,
                    data: {
                        action: 'kopa_ajax_set_user_rate',
                        wpnonce: jQuery('#kopa_set_user_rate_wpnonce').val(),
                        post_id: ad_mag_lite_front_variable.template.post_id,
                        rate_value: value/10
                    },
                    success: function(data) {

                        jQuery('.kopa-slider').html(' You rated ( '+value+'% ) ');
 
                        var star_count =  Math.floor(data.new_result*5/10);
                        var stars_html = "";
                        for(var i=0; i < star_count; i++){
                            stars_html += '<li><span class="fa fa-star"></span></li>';

                        }
                        if((data.new_result*5/10 - star_count) >= 0.5){
                            stars_html += '<li><span class="fa fa-star-half-o"></span></li>';
                            star_count++;
                        }
                        for (var j=0; j<5-star_count; j++){
                            stars_html += '<li><span class="fa fa-star-o"></span></li>';
                        }

                        jQuery('.kopa-rating > ul').html(stars_html);
                        jQuery('.rv-thumb > p').html(data.new_result)
                        //disable user rating
                        jQuery('.slider-horizontal').css('display','none');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });
        }
    }]);
};

 /* =========================================================
13. Accordion Slider
============================================================ */

    Modernizr.load([{
        load: [ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.zaccordion.min.js', ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/matchMedia.js',   
            ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/matchMedia.addListener.js',
            ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/enquire.min.js'],
        complete: function () {
            var auto_play = jQuery('.acc-slider').data('autoplay');
            var speed = jQuery('.acc-slider').data('speed');
            var timeout = jQuery('.acc-slider').data('timeout');
            var as_width = jQuery('.kopa-accordion-slider-widget').width();
            var ai_width = (as_width - 200)/as_width;
            var example = jQuery('.acc-slider'),
            defaults = {
                slideClass: 'aslider',
                pause: true,
                timeout: timeout,
                auto: auto_play,
                speed: speed,
                startingSlide: 2,
                animationStart: function () {
                    example.children('li.aslider-previous').find('.entry-content').css('opacity', '0');
                    example.children('li.aslider-previous').find('.entry-view').css('opacity', '0');
                    example.children('li.aslider-open').find('.h5-content').css({
                        'opacity': '0'
                    });
                },
                animationComplete: function () {
                    example.children('li.aslider-open').find('.entry-content').css({
                        'opacity': '1'
                    });
                    example.children('li.aslider-open').find('.h5-content').css({
                        'opacity': '1'
                    });

                    example.children('li.aslider-open').find('.entry-view').css({
                        'opacity': '1'
                    });
                },
                buildComplete: function () {
                    example.css('visibility', 'visible');
                    example.children('li.aslider-closed').find('.entry-view').css('opacity', '0');
                    example.children('li.aslider-open').find('.entry-content').css('opacity', '1');
                    example.children('li.aslider-open').find('.h5-content').css({
                        'opacity': '1'
                    });
                }
            };

            function build(x) {
                var opts, current;
                if (!jQuery.isEmptyObject(example.data())) { /* If an zAccordion is found, rebuild it with new settings. */
                    example.css('visibility', 'hidden');
                    current = example.data('current');
                    opts = jQuery.extend({
                        startingSlide: current
                    }, defaults, x);
                    example.zAccordion('destroy', {
                        removeStyleAttr: true,
                        removeClasses: true,
                        destroyComplete: {
                            afterDestroy: function() {
                                try {
                                    console.log('zAccordion destroyed! Attempting to rebuild...');
                                } catch (e) {}
                            },
                            rebuild: opts
                        }
                    });
                } else { /* If no zAccordion is found, build one from scratch. */
                    example.css('visibility', 'hidden');
                    opts = jQuery.extend(defaults, x);
                    example.zAccordion(opts);
                }
            }


/* ============================================
14. Enquire
=============================================== */

            /* A unique Media Query is registered for each screen size. */
            enquire.register('screen and (min-width: 1160px)', { /* Standard screen sizes and a default build for browsers that are unsupported. */
                match : function () {
                    build({
                        width: as_width,
                        slideWidth: 778,
                        height: 394
                    });
                } /* The *true* value below means this media query will fire by default. */
            }, true).register('screen  and (min-width: 1024px) and (max-width: 1159px)', {
                match : function () {
                    build({
                        width: 980,
                        slideWidth: 880,
                        height: 446
                    });
                }
            }).register('screen and (min-width: 980px) and (max-width: 1023px)', {
                match : function () {
                    build({
                        width: 940,
                        slideWidth: 840,
                        height: 426
                    });
                }
            }).register('screen and (min-width: 800px) and (max-width: 979px)', {
                match : function () {
                    build({
                        width: 760,
                        slideWidth: 660,
                        height: 336
                    });
                }
            }).register('screen and (min-width: 768px) and (max-width: 799px)', {
                match : function () {
                    build({
                        width: 728,
                        slideWidth: 628,
                        height: 320
                    });
                }
            }).register('screen and (min-width: 720px) and (max-width: 767px)', {
                match : function () {
                    build({
                        width: 680,
                        slideWidth: 580,
                        height: 294
                    });
                }
            }).register('screen and (min-width: 640px) and (max-width: 719px)', {
                match : function () {
                    build({
                        width: 600,
                        slideWidth: 550,
                        height: 280
                    });
                }
            }).register('screen and (min-width: 480px) and (max-width: 639px)', {
                match : function () {
                    build({
                        width: 440,
                        slideWidth: 400,
                        height: 202
                    });
                }
            }).register('screen and (min-width: 360px) and (max-width: 479px)', {
                match : function () {
                    build({
                        width: 320,
                        slideWidth: 300,
                        height: 150
                    });
                }
            }).register('screen and (min-width: 320px) and (max-width: 359px)', {
                match : function () {
                    build({
                        width: 300,
                        slideWidth: 280,
                        height: 140
                    });
                }
            });
        }   

    }]);

/* =========================================================
15. Fix css ie8
============================================================ */
    jQuery(".e-heading p:last-child").css("margin-bottom", "0");
    jQuery(".sf-mega.style1 .sf-mega-section:last-child").css("border-right", "none");
    jQuery(".sf-mega.style2 .sf-mega-section:last-child").css("border-right", "none");
    jQuery(".sf-mega-mobile .sf-mega-section-mobile .sub-menu li:last-child a").css("padding-bottom", "0");
    jQuery(".widget-area-16 .widget:last-child").css("margin-bottom", "0");
    jQuery(".widget-area-17 .widget:last-child").css("margin-bottom", "0");


/* ============================================
16. Match height
=============================================== */

    if (jQuery('.bottom-area-2').length > 0) {
    
        Modernizr.load([{
            load: [ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.matchHeight-min.js'],
            complete: function () {

                var post_1 = jQuery('.bottom-area-2');
                
                post_1.each(function() {
                    jQuery(this).children('div').matchHeight();
                });
            }
        }]);

    };

    if (jQuery('.warea-wrap').length > 0) {
    
        Modernizr.load([{
            load: [ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.matchHeight-min.js'],
            complete: function () {

                var post_1 = jQuery('.warea-wrap');
                
                post_1.each(function() {
                    jQuery(this).children('div').matchHeight();
                });
            }
        }]);

    };

    var s_h = jQuery('.woocommerce').find('ul.products');
    if (s_h.length > 0) {
    
        Modernizr.load([{
            load: [ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.matchHeight-min.js'],
            complete: function () {
                
                s_h.each(function() {
                    jQuery(this).children('li').matchHeight();
                });
            }
        }]);

    };

    if (jQuery('.article-list-6').length > 0) {
    
        Modernizr.load([{
            load: [ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.matchHeight-min.js'],
            complete: function () {

                var post_3 = jQuery('.article-list-6').find("ul");
                
                post_3.each(function() {
                    jQuery(this).children('li').matchHeight();
                });
            }
        }]);

    };

    if (jQuery('.article-list-5').length > 0) {
    
        Modernizr.load([{
            load: [ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/jquery.matchHeight-min.js'],
            complete: function () {

                var post_4 = jQuery('.article-list-5').find("ul");
                
                post_4.each(function() {
                    jQuery(this).children('li').matchHeight();
                });
            }
        }]);

    };

/* =========================================================
17. Sticky menu
============================================================ */ 
    if(ad_mag_lite_custom_front_localization.sticky_menu == 1 ){
        Modernizr.load([{
            load: [ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/waypoints.js', ad_mag_lite_custom_front_localization.url.template_directory_uri + '/js/waypoints-sticky.js'],
            complete: function () {
                jQuery('.kopa-header-bottom').waypoint('sticky');
            }
        }]);
    }

});

function ad_mag_lite_load_more_blog_3() {

    jQuery.ajax({       
            type: 'POST',
            url: ad_mag_lite_front_variable.ajax.url,
            dataType: 'html',
            async: false,
            data: {
                action: 'ad_mag_lite_load_more_blog_3',
                wpnonce: jQuery('#ad_mag_lite_load_more_blog_3_wpnonce').val(),
                postoffset : jQuery('.kopa-masonry-6-widget .kopa-masonry-wrap').children().size(),
                cat_id: jQuery('#cat_id').val(),
            },
            beforeSend: function(XMLHttpRequest, settings) {
               //jQuery('body').addClass('infscr-loading');
            },
            complete: function(XMLHttpRequest, textStatus) {
              //jQuery('.kopa-loadmore').removeClass('infscr-loading');
            },
            success: function(data) {
                jQuery('.kopa-masonry-6-widget .kopa-masonry-wrap').append(data);
                jQuery('.kopa-masonry-6-widget .kopa-masonry-wrap').masonry('reloadItems');
                jQuery('.kopa-masonry-6-widget .kopa-masonry-wrap').masonry('layout');
                if( jQuery('.kopa-masonry-6-widget .kopa-masonry-wrap').children().size() == jQuery('#total_post').val() ){
                    jQuery('.kopa-loadmore').css("display","none");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });

    return false;
}

function ad_mag_lite_load_more_blog_2() {
    jQuery.ajax({       
            type: 'POST',
            url: ad_mag_lite_front_variable.ajax.url,
            dataType: 'html',
            async: true,
            data: {
                action: 'ad_mag_lite_load_more_blog_2',
                wpnonce: jQuery('#ad_mag_lite_load_more_blog_2_wpnonce').val(),
                postoffset : jQuery('.kopa-masonry-6-widget .kopa-masonry-wrap').children().size(),
                cat_id: jQuery('#cat_id').val(),
                index: jQuery('.kopa-masonry-wrap li:last-child').attr('data-index') //jQuery('#blog-2 > li:last').data('index')
            },
            beforeSend: function(XMLHttpRequest, settings) {
               // jQuery('body').addClass('infscr-loading');
            },
            complete: function(XMLHttpRequest, textStatus) {
              // jQuery('.kopa-loadmore').removeClass('infscr-loading');
            },
            success: function(data) {
                jQuery('.kopa-masonry-6-widget .kopa-masonry-wrap').append(data);
                jQuery('.kopa-masonry-6-widget .kopa-masonry-wrap').masonry('reloadItems');
                jQuery('.kopa-masonry-6-widget .kopa-masonry-wrap').masonry('layout');
                if( jQuery('.kopa-masonry-6-widget .kopa-masonry-wrap').children().size() == jQuery('#total_post').val() ){
                    jQuery('.kopa-loadmore').css("display","none");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });

    return false;
}

// Check to hide readmore 
if( jQuery('.kopa-masonry-6-widget .kopa-masonry-wrap').children().size() == jQuery('#total_post').val() ){
    jQuery('.kopa-loadmore').css("display","none");
}


// Paginate Article List Style 9
jQuery(document).ready(function(){
    jQuery('ul#items').easyPaginate({
        step: jQuery('ul#items').data('post-per-page')
    });
});

// Loadmore mansory 6 widget
jQuery(document).ready(function () {
    var size_li = jQuery("#load-more-mansory-6 > li").size();
    var x = jQuery("#load-more-mansory-6").data('post-per-page');
    var y = jQuery("#load-more-mansory-6").data('post-per-page');
    jQuery('#load-more-mansory-6 > li:lt('+x+')').show();
    jQuery('#load-more-mansory-6 > li:lt('+x+')').addClass('status');

    if( jQuery('#load-more-mansory-6 > li.status').length == jQuery("#load-more-mansory-6").data('total-post') ){
        jQuery('#load-more-mansory-6-button').css("display","none");
    }

    jQuery('#load-more-mansory-6-button').click(function () {
        x = (x+y <= size_li) ? x+y : size_li;
        jQuery('#load-more-mansory-6 > li:lt('+x+')').show();
        jQuery('#load-more-mansory-6 > li:lt('+x+')').addClass('status');
        jQuery('#load-more-mansory-6').masonry('reloadItems');
        jQuery('#load-more-mansory-6').masonry('layout');
        
        if( jQuery('#load-more-mansory-6 > li.status').length == jQuery("#load-more-mansory-6").data('total-post') ){
            jQuery('#load-more-mansory-6-button').css("display","none");
        }
    });
});

