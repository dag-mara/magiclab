;(function ($, window, undefined) {
	'use strict';

	$(document).ready(function() {

		var iso_container = $('#projects-container');
		var iso_filters = $('.project-tax-list');
		iso_container.imagesLoaded( function() {
			iso_container.isotope({
				itemSelector: '.mau_project',
				layoutMode: 'fitRows'
			});
		});
		iso_filters.on( 'click', 'li', function(e) {
			e.preventDefault();
			var t = $(this);
			if ( t.is('.active') ) {
				t.removeClass('active');
				iso_container.isotope({ filter: '*' });
			} else {
				$('.active',iso_filters).removeClass('active');
				iso_container.isotope({ filter: '.in-tax-'+t.data('term-id') });
				t.addClass('active');
			}
		});

	}); // end of doc ready

})(jQuery, this);
