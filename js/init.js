;( function( $, window, document, undefined ) {

	'use strict';

	// Selectors
	var $window			= $( window ),
		$body			= $( 'body' ),
		$document		= $( document );

	$document.ready(function() {

		// Get positions
		var themeNames = [ 'Videoblog' ];

		$('.themewrap').each(function( index ) {
			var themeName = $( this ).find('.details').text(),
				themePosition = index + 1;

			$.each(themeNames, function(index, value){
				if(value == themeName) {
					$('.themepositions').append('<div>' + value + ' is on position: #' + themePosition + '</div>')
				}
			});
		});

		// Lazy load
		$('img.screenshot').error(function(){
			$(this).attr('src', trtPlaceholderIMG);
		});
		$('img.screenshot').unveil(400, function() {
			var data_src = $(this).attr('data-src');
			$(this).error(function() {
				console.warn(data_src);
				$(this).attr("src", data_src.replace('.png', '.jpg')).off('error');
			});
			$(this).load(function() {
				this.style.opacity = 1;
			});
		});

	})

	// Preloader
	$window.load(function(){
		$('#trt-preloader').fadeOut('slow',function(){$(this).remove();});
	});

})( jQuery, window, document );
