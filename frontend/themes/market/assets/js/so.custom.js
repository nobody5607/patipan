/* Add Custom Code Jquery
 ========================================================*/
$(document).ready(function(){
	// Fix hover on IOS
	$('body').bind('touchstart', function() {}); 
	

	// Messenger posmotion
	$( "#close-posmotion-header" ).click(function() {
		$('.promotion-top').toggleClass('hidden-promotion');
		$('body').toggleClass('hidden-promotion-body');

		if($(".promotion-top").hasClass("hidden-promotion")){
			$.cookie("open", 0);
			
		} else{
			$.cookie("open", 1);
		}

	});
	
	if($.cookie("open") == 0){
		$('.promotion-top').addClass('hidden-promotion');
		$('body').addClass('hidden-promotion-body');
	}


	// Messenger Top Link
	$('.list-msg').owlCarousel2({
		pagination: false,
		center: false,
		nav: false,
		dots: false,
		loop: true,
		slideBy: 1,
		autoplay: true,
		margin: 30,
		autoplayTimeout: 4500,
		autoplayHoverPause: true,
		autoplaySpeed: 1200,
		startPosition: 0, 
		responsive:{
			0:{
				items:1
			},
			480:{
				items:1
			},
			768:{
				items:1
			},
			1200:{
				items:1
			}
		}
	});






	// Close pop up countdown
	 $( "#so_popup_countdown .customer a" ).click(function() {
	  $('body').toggleClass('hidden-popup-countdown');
	 });
	// =========================================


	// click header search header 
	jQuery(document).ready(function($){
		$( ".search-header-w .icon-search" ).click(function() {
		$('#sosearchpro .search').slideToggle(200);
		$(this).toggleClass('active');
		});
	});

	// add class Box categories
	jQuery(document).ready(function($){

		if($("#accordion-category .panel .panel-collapse").hasClass("in")){
			$('#accordion-category .panel .accordion-toggle').addClass("show");			
		} 
		else{
			$('#accordion-category .panel .accordion-toggle').removeClass("show");
		}

	});

	// slider categories
	jQuery(document).ready(function($) {
	    var slidercate = $(".layout-2 .so-categories.custom-slidercates .cat-wrap");
	    slidercate.owlCarousel2({    
	    margin:30,
	    nav:true,
	    loop:false,
	    dots: false,
	    navText: ['',''],
	    responsive:{
	            0:{
	                items:1
	            },
	            480:{
	                items:2
	            },
	            768:{
	                items:3
	            },
	            992:{
	                items:4
	            },
	            1200:{
	                items:5
	            },
	        },
	    })
	});

	jQuery(document).ready(function($) {
	    var slidercate = $(".layout-3 .so-categories.custom-slidercates .cat-wrap");
	    slidercate.owlCarousel2({    
	    margin:30,
	    nav:true,
	    loop:true,
	    dots: false,
	    navText: ['',''],
	    responsive:{
	            0:{
	                items:1
	            },
	            480:{
	                items:2
	            },
	            768:{
	                items:3
	            },
	            992:{
	                items:4
	            },
	            1200:{
	                items:4
	            },
	        },
	    })
	});


	// custom to show footer center
	$(".description-toggle").click(function () {
		if($('.showmore').hasClass('active'))
			$('.showmore').removeClass('active');
		else
			$('.showmore').addClass('active');
	}); 


	$(".content-product-content .button-toggle").click(function () {
		if($(this).children('.showmore').hasClass('active')) $(this).children().removeClass('active');
		else $(this).children().addClass('active');
		
		
		
		if($(this).prev().hasClass('showdown')) $(this).prev().removeClass('showdown').addClass('showup');
		else $(this).prev().removeClass('showup').addClass('showdown');
	}); 

	$(".clearable").each(function() {
  
	  var $inp = $(this).find("input:text"),
	      $cle = $(this).find(".clearable__clear");

	  $inp.on("input", function(){
	    $cle.toggle(!!this.value);
	  });
	  
	  $cle.on("touchstart click", function(e) {
	    e.preventDefault();
	    $inp.val("").trigger("input");
	  });
	  
	});

});
