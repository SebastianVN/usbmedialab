jQuery(document).ready(function($){
'use strict';
/*==========================*/	
/*Preloader */	
/*==========================*/
$('.preloader').delay(350).fadeOut('slow');
/*==========================*/	
/*  Menu */	
/*==========================*/
//jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});

	 $(".navbar-nav li a").click(function (event) {
    var toggle = $(".navbar-toggle").is(":visible");
    if (toggle) {
      $(".navbar-collapse").collapse('hide');
    }
  });

  
/*==========================*/	
/* Slider */	
/*==========================*/
 $('.hero-slider').slick({
  dots: true,
  autoplay: true,
  autoplaySpeed: 4000,
  infinite: true,
  speed: 300,
  pauseOnHover: false,
  slidesToShow: 1,
  adaptiveHeight: false,
  fade:false,
});


 $('.slider').slick({
  dots: true,
  autoplay: true,
  autoplaySpeed: 4000,
  infinite: true,
  speed: 300,
  pauseOnHover: false,
  slidesToShow: 1,
  adaptiveHeight: false,
  fade:false,
});
  
 
/*==========================*/	
/* Parallax effect */	
/*==========================*/
$('.parallax').sparallax(); 

/*==========================*/	
/* Tabs Changes to Accorion on mobile */	
/*==========================*/
$('.nav-tabs').tabCollapse();

/*==========================*/	
/* Fix on Scroll */	
/*==========================*/
$('.fix').theiaStickySidebar({
      // Settings
      additionalMarginTop: 60
    });

/*==========================*/	
/* Lighbox */	
/*==========================*/	
$('.popup-youtube, .popup-vimeo').magnificPopup({
	
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
        fixedContentPos: false
	});
	
		
/*----------------------------------------------------*/
/*	Faq Page 
/*----------------------------------------------------*/

var query = $('ul.events-list');
 
// check if element is Visible
var isVisible = query.is(':visible');
 
if (isVisible === true) {
   $('ul.events-list > li > a').click(function(){
	 
		$('html, body').animate({
			scrollTop: $('.event-tabs').offset().top -60
		}, 300);
	 
	
});
}  


$('.search-icon a').click(function(){
	$('body').addClass('show-search');
	return false;
});

$('.close-search').click(function(){
	$('body').removeClass('show-search');
	return false;
});



if ($('.go-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('.go-top').addClass('show');
            } else {
                $('.go-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('.go-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700, 'easeInOutExpo');
    });
}


/*==========================*/	
/* Google Map */	
/*==========================*/
	if($('#map-canvas').length != 0){
		var map;
		function initialize() {
			var mapOptions = {
				zoom: 15,
				scrollwheel: false,
			 	center: new google.maps.LatLng(25.932884, 83.569633),
			 	styles: [
							{"stylers": [{ hue: "#ce9f51" },
							{ saturation: -100 },
							{ lightness: 0 }]},
    					{
					      "featureType": "road",
					      "elementType": "labels",
					      "stylers": [{"visibility": "off"}]
					    },
					    {
					      "featureType": "road",
					      "elementType": "geometry",
					      "stylers": [{"lightness": 100},
					            {"visibility": "simplified"}]
					    }
			 	]
			};
			map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			var image = 'include/images/map-marker.png';
			var myLatLng = new google.maps.LatLng(25.932884, 83.569633);
			var beachMarker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: image
			 });
		}

		google.maps.event.addDomListener(window, 'load', initialize);
	}


var scroll = $(window).scrollTop();

    if (scroll >= 80) {
        $("header").addClass("fixed");
    } else {
        $("header").removeClass("fixed");
    }
	
});	

	
 

$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 80) {
        $("header").addClass("fixed");
    } else {
        $("header").removeClass("fixed");
    }
});

 
 

