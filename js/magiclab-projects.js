;(function ($, window, undefined) {
	'use strict';
	$(document).ready(function() {
		var pro_container = $('#projects-container');
		var pro_items = $('article',pro_container);
		var pro_filters = $('.project-tax-list');
		pro_filters.on( 'click', 'li', function(e) {
			e.preventDefault();
			var t = $(this);
			var termId = t.data('term-id')
			if ( ! t.is('.active') ) {
				$('.active', pro_filters).removeClass('active');
				t.addClass('active');
				if (termId) {
					pro_items.hide().filter('.in-tax-' + termId).show();
				} else {
					pro_items.show();
				}
			}
		});
		if(window.location.hash) {
			$('[data-term="'+window.location.hash.substring(1)+'"]').click();
		}
	}); // end of doc ready
})(jQuery, this);
