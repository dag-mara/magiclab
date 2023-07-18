;(function ($, window, undefined) {
	'use strict';

	// @TODO/IDEA: instad of using prev el a "ghost" el could be inserted in place of original topbar
	// ghost would stay in place and be used to determine originalTopBarOffset if needed
	// could also deal with height jump instead of .has-sticky-top
	var originalTopBarOffset,originalTopBarHeight;
	var topBar = $('.top-bar');
	var topBarParent = topBar.parent();
	var topBarAccess = $('#access');
	topBarParent.addClass('hw-acc');

	originalTopBarHeight = topBar.height();
	topBar.hide();

	var is_landscape = function() {
		return window.innerWidth > window.innerHeight;
	};

	var updateTopBarVars = function(prev_el) {
		originalTopBarOffset = topBarAccess.offset().top;
	};

	var doc = $(document);
	var win = $(window);
	var body = $('body');

	var updateTopBarPosition = function(){
		if ( doc.scrollTop() > originalTopBarOffset ) {
			topBarParent.addClass('sticky-top');
			body.addClass('has-sticky-top');
		} else {
			topBarParent.removeClass('sticky-top');
			body.removeClass('has-sticky-top');
		}
	};

	var topBarInit = function(prev_el) {
		updateTopBarVars(prev_el);
		updateTopBarPosition();
		topBar.fadeIn(300);
	};

	var featProjects = $('.featured.projects');
	var updateBodyClass = function() {
		if ( doc.scrollTop()+win.height() > featProjects.offset().top+100 ) {
			body.addClass('scrolled');
		} else {
			body.removeClass('scrolled');
		}
	};

	var updateSlidesSize = function(slides) {
		var newHeight = is_landscape() ? window.innerHeight - topBar.height() : '';
		slides.height(newHeight);
	};

	MagicLab.videoLightBox = function() {

		var orb_controls = $('.orbit-slide-number,.orbit-prev,.orbit-next,.orbit-timer,.orbit-bullets-container');
		var b = $('body');
		var h;

		// Overlay div
		var overlay = $('<div/>',{'class':'video-overlay'}).click(function(e){
			// prevent orbit timer autorun on video close
			$('.orbit-timer','.featured-slider').click();
			closeOverlay();
		});

		var openOverlay = function() {
			orb_controls.fadeOut(800);
			b.addClass('overlay-active');
			// Add close overlay link
			$('<span/>',{'class':'close-video-overlay'}).click(function(e){
				e.preventDefault();
				closeOverlay();
			}).appendTo(overlay);
			overlay.appendTo(b).fadeIn();
		};

		var closeOverlay = function() {
			orb_controls.fadeIn(800);
			if ( h ) {
				h.fadeOut();
			}
			overlay.fadeOut(800,function(){
				overlay.html('').remove();
				b.removeClass('overlay-active');
			});
		};

		var getVideoIFrameURL = function(el) {
			var videoID = el.data('video-id');
			var provider = el.data('video-provider');
			switch (provider) {
				case 'vimeo':
					return '//player.vimeo.com/video/'+videoID+'?byline=0&portrait=0&title=0&badge=0&autoplay=1&api=1';
				case 'youtube':
					return '//www.youtube.com/embed/'+videoID+'?autoplay=1&disablekb=1&modestbranding=1&rel=0&iv_load_policy=3';
				default:
					return '';
			}
		}

		var appendVideoIframe = function(el) {
			var src = getVideoIFrameURL(el);
			if ( ! src ) {
				return false;
			}
			$('<iframe/>',{
				'class': 'inserted-video',
				'src': src,
				'css': {width:'100%',height:'100%'},
				'frameborder': 0,
				'allowfullscreen': 'true',
			}).appendTo(overlay);
		};

		$('.play_button,.trailer-link-project-lightbox,.vfx-link-project-lightbox').click(function(e){
			e.preventDefault();
			if ( b.is('.overlay-active') )
				return false;
			var t = $(this);
			var p = t.parent();
			var is_trailer = t.is('.trailer-link-project-lightbox,.vfx-link-project-lightbox');
			openOverlay();
			appendVideoIframe(t);
			if ( ! is_trailer ) {
				// Add video title to overlay
				h = $( '.video-slide-title', p ).clone().appendTo(overlay).fadeIn(800);
			}
			// Pause orbit timer on video play
			$('.orbit-timer.paused','.featured-slider').click();
		});

	};

	MagicLab.finishedProjects = {
		'init' : function() {

			this.showAllButtons = $('#finished-projects-show-all, #finished-series-show-all');

			this.view = $('<div/>',{
				'id':'info-wrapper',
				'class':'info-wrapper'
			}).appendTo('.top-bar','#access');

			this.infoboxes = $('.finished-project-info').clone();
			this.infoboxes.appendTo(this.view).show();

			var self = this;

			// Show all projects
			/*
			this.showAllButtons.click(function(e) {
				e.preventDefault();
				var t = $(this);
				if ( MagicLabL10n.all === t.text() ) {
					t.text(MagicLabL10n.showLess);
				} else {
					t.text(MagicLabL10n.all);
				}
				$('body').toggleClass(
					t.attr('id').replace('show-all', 'collapsed')
				);
			});
			*/

			// Show infobox
			$('.finished-project a','#finished-projects, #finished-series').on('click',function(e){
				e.preventDefault();
				var t = $(this);
				var p = t.parent();
				if ( p.is('.active') ) {
					self.view.addClass('anim_slide');
					self.closeView();
					return;
				}
				var active = $('.finished-project.active,.finished-project-info.active');
				var target_id = t.next('.finished-project-info').data('info-id');
				if ( active.length ) {
					self.view.removeClass('anim_slide').addClass('anim_fade');
					self.closeView();
				} else {
					self.view.removeClass('anim_fade').addClass(' anim_slide');
				}
				p.addClass('active');
				$('[data-info-id='+target_id+']',self.view).addClass('active');
				$('body').addClass('finished-project-opened');

			});
			this.view.on('click','.info-close',function(){
				self.view.addClass('anim_slide');
				self.closeView();
			});
			$(document).click(function(event) {
			    if( ! $( event.target ).closest('.finished-project,#info-wrapper,.video-overlay').length && ! $( event.target ).is('.orbit-timer') ) {
			        if( $('.active',self.view).length ) {
			        	self.view.addClass('anim_slide');
			            self.closeView();
			        }
			    }
			});
		},
	    // @unused
		'resetView' : function() {

			$('#info-wrapper').html();
			this.infoboxes = $('.finished-project-info').clone();
			this.infoboxes.appendTo(this.view).show();

			$('.finished-project a','#finished-projects, #finished-series').on('click',function(e){
				e.preventDefault();
				var t = $(this);
				var p = t.parent();
				if ( p.is('.active') ) {
					self.view.addClass('anim_slide');
					self.closeView();
					return;
				}
				var active = $('.finished-project.active,.finished-project-info.active');
				var target_id = t.next('.finished-project-info').data('info-id');
				if ( active.length ) {
					self.view.removeClass('anim_slide').addClass('anim_fade');
					self.closeView();
				} else {
					self.view.removeClass('anim_fade').addClass(' anim_slide');
				}
				p.addClass('active');
				$('[data-info-id='+target_id+']',self.view).addClass('active');
				$('body').addClass('finished-project-opened');

			});
			this.view.on('click','.info-close',function(){
				self.view.addClass('anim_slide');
				self.closeView();
			});
		},
		'closeView' : function() {
				$('.finished-project.active,.finished-project-info.active').removeClass('active');
				$('body').removeClass('finished-project-opened');
		},
		// @dry
		'isSmallView' : function() {
			return $(document).width() < 641;
		}
	};


	MagicLab.sliderParallax = function() {
		var fps = 80;
		var diff = 2;
		var container = $('#featured');
		if ( ! container.length ) {
			return;
		}
		var elements = container.add('.orbit-next,.orbit-prev,.orbit-bullets');
		elements.css({
			'will-change': 'transform',
			'transform': 'translateY(0)',
		})
		var updateElementsPosition = function() {
			var newtop = window.scrollY/diff;
			newtop = newtop >= 0 ? newtop : 0;
			elements.css({'transform': 'translateY(' + newtop + 'px)'});
		}
		$(document).ready(function() {
			updateElementsPosition();
		});
		// $(window).on('scroll', _.throttle(function(){
		//     updateElementsPosition();
		// }, 1000/fps));
		$(window).on('scroll', function(){
		    updateElementsPosition();
		});
	};

	// DOC READY
	$(document).ready(function() {

		MagicLab.finishedProjects.init();

		MagicLab.videoLightBox();

		// if ( ! MagicLab.utils.isMobile ) {
		// 	MagicLab.sliderParallax();
		// }

		updateBodyClass();

		// FEATURED SLIDER
		var featured_slider = $('#featured');
		var featured_slides = $('.slide', featured_slider);
		if ( featured_slider.length ) {

			body.addClass('js-orbit-ready');
			topBarInit(featured_slider);
			updateBodyClass();
			updateSlidesSize(featured_slides);

			// Manually trigger timer
			// @TODO load afger bg images have been loaded
			var feat_timer = $('.orbit-timer');
			if ( feat_timer.is('.paused') ) {
				feat_timer.click();
			}

			// Featured slider vs nav menu on touch
			$('.toggle-topbar a','#access').click(function(){
				featured_slider.toggle();
			});

			// SCROLL DOWN ARROW
			if ( $('body').width() > 700 ) {
				$('<a/>',{
					'href':'#',
					'text':'Scroll Down',
					'class':'scroll-down-arr'
				}).appendTo( $('.top-bar') ).click(function(e){
					e.preventDefault();
					$('body,html').stop(true,true).animate({'scrollTop': featured_slider.offset().top + featured_slider.outerHeight()-70 }, 750 );
				});
			}
		} // @endof featured_slider

	}); // @endof doc ready


	// OTHER EVENTS:

	// Featured Slider Ready
	var featured_slider = $("#featured");
	var featured_slides = $('.slide', featured_slider);

	// Window Scroll
	$(window).on('scroll', _.throttle(function(){
		updateTopBarPosition();
		updateBodyClass();
	}, 1000/80));

	// Viewport Resize
	$(window).on('resize', _.throttle(function(){
		updateTopBarVars(featured_slider);
		updateTopBarPosition();
		updateSlidesSize(featured_slides);
	}, 1000/60));

	// $(window).on('orientationchange', function() {
	// 	updateTopBarVars(featured_slider);
	// 	updateTopBarPosition();
	// 	updateSlidesSize(featured_slides);
	// });

})(jQuery, this);
