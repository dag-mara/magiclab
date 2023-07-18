<?php

// SLIDER
add_filter('startup_orbit_options', 'magiclab_orbit_options',99);
function magiclab_orbit_options($opt='') {
	$opt['timer'] = 1;
	$opt['pause_on_hover'] = 0;
	return $opt;
}


// Allow shortcode for widgets
add_filter('widget_text', 'do_shortcode');


// Remove widget areas
add_action( 'widgets_init', 'magiclab_widgets', 11 );
function magiclab_widgets(){
	unregister_sidebar( 'header' );
	unregister_sidebar( 'sidebar' );
}


// Remove admin bar on front end
add_filter('show_admin_bar', '__return_false');


// Remove top bar menu title
add_filter( 'startup_top_bar_menu_title', '__return_empty_string' );


// Login Logo
add_action('login_head', 'magiclab_login_screen');
function magiclab_login_screen() {
	$uri = get_stylesheet_directory_uri();
    echo '<style type="text/css">
        h1 { display:none }
        body { background:#F6F6F6; }
        .login form {
	        background-image: url('.$uri.'/images/magiclab_logo_black.png);
        	background-color:#F6F6F6;
	        background-position:center 20px;
	        background-repeat:no-repeat;
	        padding-top:70px;
	        box-shadow:none;
        }
        @media only screen and (-webkit-min-device-pixel-ratio: 1.5),
		    only screen and (-o-min-device-pixel-ratio: 3/2),
		    only screen and (min--moz-device-pixel-ratio: 1.5),
		    only screen and (min-device-pixel-ratio: 1.5) {
		        .login form {
		        	background-image:url('.$uri.'/images/magiclab_logo_black@2x.png);
		        	background-size:220px auto;
		        }
		}
        .wp-core-ui .button-primary {
        	background:#00acbc;
        	border-color:#008A96;
        }
        .wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover {
        	background: #008A96;
        }
        .login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover {
        	color: #00acbc;
        }
        input[type=checkbox]:focus, input[type=email]:focus, input[type=number]:focus, input[type=password]:focus, input[type=radio]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=url]:focus, select:focus, textarea:focus {
			border-color: #00acbc;
			-webkit-box-shadow: 0 0 2px rgba(0,172,188,.8);
			box-shadow: 0 0 2px rgba(0,172,188,.8);
		}
    </style>';
}