/**
 * Magiclab generic scripts
 *
 **/
var MagicLab;
;(function ($, window, undefined) {
	'use strict';

	MagicLab = {
		'init' : function() {
			this.setup();
			//this.events();
			this.checkView();
		},
		'setup' : function() {
			this.dom = {};
			this.settings = {};
			this.cache = {};
			this.cache.isSmallView = this.utils.isSmallView();
		},
		'events' : function() {
			var self = this;
			// Scroll to top
			$('#scroll-top').click(function(e){
				e.preventDefault();
				$('body,html').stop(true,true).animate({'scrollTop':0}, 800 );
			});
			// Resize
			$(window).on('resize', Foundation.utils.throttle(function(e){
				var isSmallView = self.utils.isSmallView();
				if ( isSmallView !== self.cache.isSmallView ) {
					self.cache.isSmallView = isSmallView;
					$(document).trigger( 'MagicLab:viewChanged', [isSmallView] );
				}
			}, 300));
		},
		'checkView' : function() {

		},
		'utils' : {
			'isMobile': navigator.userAgent.match(/Mobi/),
			'isSmallView': function() {
				return $(document).width() < 641;
			},
		},
	}; // @endof MagicLab

	$(document).ready(function() {
		MagicLab.init();
	});

    $(document).ready(function() {
        $( ".works-category" ).click( function() {
            var tax = $( this ).attr("data-taxonomy");
            $.ajax({
                url : ajaxurl,
                data : {'action': 'works_more',
                        'paged': '0',
                        'tax': tax },
                type : 'POST',
                success : function( data ){
                    if(data.html != null){
                        $("#projects-container").html(data.html);
                    }
                    if(data.paged != null && data.paged > 0){
                        $( ".load-more-work" ).attr("data-tax",tax);
                        $( ".load-more-work" ).attr('data-paged',data.paged);
                        $( ".load-more-work" ).show();
                    }else{
                        $( ".load-more-work" ).hide();
                    }
                }
            });
        });

        $( ".load-more-work" ).click( function() {
			var objBtn = $(this).closest('.more-link');
			objBtn.addClass('loading');
            $.ajax({
                url : ajaxurl,
                data : {'action': $( ".load-more-work" ).attr('data-call'),
                        'paged': $( ".load-more-work" ).attr('data-paged'),
                        'tax': $(".load-more-work" ).attr("data-tax") },
                type : 'POST',
                success : function( data ){
					objBtn.removeClass('loading');
                    if(data.html != null){
                        $("#projects-container").append(data.html);
                    }
                    if(data.paged != null && data.paged > 0){
                        $( ".load-more-work" ).attr('data-paged',data.paged);
                    }else{
                        $( ".load-more-work" ).hide();
                    }
                    //$( ".btns" ).removeClass('loading');
                }
            });
        });

		$('.viewMore').click( function() {

			var pagetype = $(this).attr('data-page-type');
			var target   = $(this).closest('.row').attr('id');
            $.ajax({
                url : ajaxurl,
                data : {'action': 'finished_more',
                        'pagetype': pagetype,},
                type : 'POST',
                success : function( data ){
                    if(data.html != null){
						$("#"+target+" .data-projects").append(data.html);
						$("#"+target+" .viewMore").hide();
						lazyload.update();
						MagicLab.finishedProjects.init();
						//MagicLab.finishedProjects.resetView();
                    }
                }
            });
        });


    });

})(jQuery, this);
