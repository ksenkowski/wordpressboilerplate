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
		
	});
	
})(jQuery, this);
