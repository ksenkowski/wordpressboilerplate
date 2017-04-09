(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		$('.open-menu').on('click', function(e){
			e.preventDefault();
			$('.slide-left, .mask').toggleClass('active');
		});
		$('.close-menu').on('click', function(e){
			e.preventDefault();
			$('.slide-left, .mask').toggleClass('active');
		});
		
		var theOffset = $('.header-sync').offset().top;
		
		$(window).scroll(function(){
		  var sticky = $('.header .sticky'),
		      scrollPosition = $(window).scrollTop();
			  console.log(theOffset + ', ' + scrollPosition);
		  if (scrollPosition >= theOffset){				  
			  sticky.addClass('show');
		  }else{
		  	sticky.removeClass('show');
		  }
		});		
		
	});
	
})(jQuery, this);