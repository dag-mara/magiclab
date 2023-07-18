;(function ($, window, undefined) {
	'use strict';

	MagicLab.synopsisControls = function() {
		$('.project-synopsis-trigger').click(function(e) {
			e.preventDefault();
			var t = $(this);
			var s = t.next('.project-synopsis');
			var a = s.next('.project-awards');
			var hideByDefault = s.is('.hidden-by-default');
			if ( s.is('.hidden') ) {
				t.addClass('active');
				s.slideDown(function(){
					s.removeClass('hidden');
				});
				t.text(MagicLabL10n.hideSynopsis);
				// if ( hideByDefault ) {
					// a.hide();
					// a.slideUp();
				// }
			} else {
				t.removeClass('active');
				s.slideUp(function(){
					s.addClass('hidden');
				});
				t.text(MagicLabL10n.showSynopsis);
				// if ( hideByDefault ) {
					// a.show();
					// a.slideDown();
				// }
			}
		});
	}

	MagicLab.projectControls = function() {
		var self = this;
		this.cache.activeProject = null;
		this.dom.articles = $('article.type-mau_project,article.type-mau_clients_project');
		// project info on small screens
		var speed = 400;
		$('<a/>',{
			'class' : 'project-info-toggle magic-plus-button',
			'text'  : MagicLabL10n.info,
			'href'  : '#info',
		}).insertAfter($('.video',this.dom.articles)).click(function(e){
			e.preventDefault();
			var t = $(this);
			if ( t.is('.active') ) {
				closeActiveProject();
			} else {
				setActiveProject(t.parent().parent())
			}
		});
		var closeActiveProject = function() {
			if ( null === self.cache.activeProject ) {
				return;
			}
			$('.entry', self.cache.activeProject).slideUp(speed);
			$('.project-info-toggle', self.cache.activeProject).removeClass('active');
			self.cache.activeProject.removeClass('in-view');
			self.cache.activeProject = null;
		}
		var setActiveProject = function(project) {
			closeActiveProject();
			self.cache.activeProject = project;
			$('.entry', self.cache.activeProject).slideDown(speed);
			$('.project-info-toggle', self.cache.activeProject).addClass('active');
			self.cache.activeProject.addClass('in-view');
		}
		// set active project on load
		if ( window.location.hash && this.utils.isSmallView() ) {
			var activeProject = $('article'+window.location.hash);
			if ( activeProject.length ) {
				setActiveProject(activeProject);
			}
		}
		$(document).on('MagicLab:viewChanged',function(event, bigToSmall) {
			if ( bigToSmall ) {
				var projectInView = $('article.in-view');
				if ( projectInView.length ) {
					setActiveProject(projectInView);
				}
			} else {
				$('.entry', self.dom.articles).show();
				if ( null !== self.cache.activeProject ) {
					$('.project-info-toggle', self.cache.activeProject).removeClass('active');
					self.cache.activeProject = null;
				}
			}
		});
	};

	$(document).ready(function() {

		MagicLab.projectControls();
		MagicLab.synopsisControls();

		// @todo dry
		var articles = $('article.type-mau_project,article.type-mau_clients_project');

		var ui_delay = 0;

		if ( ! MagicLab.utils.isSmallView() ) {

			var scrollStart = function(link) {
				if ( $(document.body).is('.scrolling') )
					return false;
				$(document.body).addClass('scrolling');
				var p = link.parents('article:first');
				var el = link.is('.prev-link') ? p.prev() : p.next();
				p.removeClass('in-view');
				$('body,html').stop(true,true).animate({'scrollTop': el.offset().top}, 500 , function(){
					window.location.hash = el.attr('id');
					el.addClass('in-view');
					$(document.body).delay(ui_delay).queue(function(next){$(this).removeClass('scrolling');});
				});
			}

			// Append links: .next-link, .prev-link
			var render_links = function() {
				var dir = ['next','prev'];
				for (var i = dir.length - 1; i >= 0; i--) {
					var not = 'prev' === dir[i] ? 'first':'last';
					var appendToTargets = $('.video', articles.not(':'+not));
					$('<a/>',{'href':'#'+dir[i],'text':dir[i],'class':dir[i]+'-link'}).click(function(e){
						e.preventDefault();
						scrollStart($(this));
					}).appendTo(appendToTargets).each(function(){
						var t = $(this);
						var p = t.parents('article:first');
						var a = 'prev' === dir[i] ? p.prev() : p.next();
						t.text($('h1',a).text());
						t.attr('href','#'+a.attr('id'));
					});
				};
			}
			render_links();

			// Determine viewed
			if ( window.location.hash ) {
				var req_article = $('article'+window.location.hash);
				// req_article.addClass('in-view');
				$('body,html').stop(true,true).animate({'scrollTop': req_article.offset().top}, 0 , function(){
					// window.location.hash = el.attr('id');
					req_article.addClass('in-view');
					$(document.body).queue(function(next){$(this).removeClass('scrolling');});
				});
			} else {
				$('article:first').addClass('in-view');
			}

			// Bind keys
			 $(document).bind('keydown', function(e){
		 		if ( 38 == e.keyCode ) {
		 			e.preventDefault();
		 			ui_delay = 0;
		 			$('.in-view .prev-link').click();
		 			return false;
		 		}
		 		if ( 40 == e.keyCode ) {
		 			e.preventDefault();
		 			ui_delay = 0;
	 				$('.in-view .next-link').click();
	 				return false;
		 		}
			 })

			// Bind mousewheel
/*
			$(document).mousewheel(function(event, delta) {
				// Detect horizontal scroll
				if ( Math.abs(event.deltaX) > Math.abs(event.deltaY) )
					return true;
				// Disallow default scrolling
				event.preventDefault();
				// Don't run when animation in progress
				if ( $(document.body).is('.scrolling') )
					return false;
				// Ignore accidental low velocity touches
				if ( Math.abs(delta) < 5 )
					return false;
				// Detect direction
				var dir = delta > 0 ? 'prev' : 'next';
				// Trigger custom scroll
				var link = $('.in-view .'+dir+'-link');
				ui_delay = 500;
				link.click();
			});
*/

			// Bind swipe
/*
	      $(".site-wrapper").swipe({
	      	swipeUp: function() {
      			var link = $('.in-view .next-link');
      			ui_delay = 0;
      			link.length && link.click();
	      	},
	      	swipeDown: function() {
      			var link = $('.in-view .prev-link');
      			ui_delay = 0;
      			link.length && link.click();
	      	},
		    preventDefaultEvents: true,
		    fallbackToMouseEvents: false,
	        allowPageScroll: 'none',
	        threshold: 35, //Default is 75px, set to 0 for demo so any distance triggers swipe
	      });*/
	    }


// @endif !MagicLab.utils.isSmallView()


		// Replace video thumbnail with video embed and play
		// @todo DRY
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
		$('.play_button').click(function(e){
			e.preventDefault();
			$('iframe.inserted-video').remove();
			$('body').trigger('magiclab:vimeoInserted');
			var t = $(this);
			var p = t.parent();
			var src = getVideoIFrameURL($('.video-thumb', p));
			if ( ! src ) {
				return false;
			}
			$('<iframe/>',{
				'class': 'inserted-video',
				'src': src,
				'frameborder': 0,
				'allowfullscreen': true
			}).appendTo(p);
		});
	}); // @endof doc ready
})(jQuery, this);