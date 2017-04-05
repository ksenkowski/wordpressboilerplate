(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		// DOM ready, take it away
		$('.open-menu').on('click', function(e){
			e.preventDefault();
			$('.slide-left, .mask').toggleClass('active');
		});
		$('.close-menu').on('click', function(e){
			e.preventDefault();
			$('.slide-left, .mask').toggleClass('active');
		});
		
		var theOffset = $('.hero').offset().top;
		
		$(window).scroll(function(){
		  var sticky = $('.sticky .button-group'),
		      scroll = $(window).scrollTop();
			  console.log(sticky ', ' scroll);
		  if (scroll >= theOffset){				  
			  sticky.addClass('show');
		  }else{
		  	sticky.removeClass('show');
		  }
		});		
		
		
	});
	
})(jQuery, this);
