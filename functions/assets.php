<?php

add_action('wp_enqueue_scripts', 'magiclab_scripts');
function magiclab_scripts(){
	$ver = magiclab_get_version();
	$min = false;
	$min = $min ? '.min':'';
	wp_enqueue_script('magiclab', get_stylesheet_directory_uri().'/js/magiclab'.$min.'.js', array('jquery','foundation','startup'), $ver, true);
	wp_enqueue_script('magiclab-lazy', get_stylesheet_directory_uri().'/js/lazy.min.js', array('jquery','foundation','startup'), $ver, true);
	if ( is_front_page() ) {
		wp_enqueue_script('underscore');
		wp_enqueue_script('magiclab-home', get_stylesheet_directory_uri().'/js/magiclab-home'.$min.'.js', array('jquery','underscore','foundation','startup','magiclab'), $ver, true);
	} elseif ( is_post_type_archive('mau_project') ) {
		wp_enqueue_script('magiclab-projects', get_stylesheet_directory_uri().'/js/magiclab-projects'.$min.'.js', array('jquery','magiclab'), $ver, true);
	} elseif ( is_tax('mau_project_tax') || is_tax('mau_clients_projects_category') ) {
/*
		wp_enqueue_script('mousewheel', get_stylesheet_directory_uri().'/js/jquery.mousewheel.min.js', array('jquery'), '3.1.11', true);
		wp_enqueue_script('touchSwipe', get_stylesheet_directory_uri().'/js/jquery.touchSwipe.min.js', array('jquery'), '1.0', true);
*/
		wp_enqueue_script('magiclab-tax', get_stylesheet_directory_uri().'/js/magiclab-tax'.$min.'.js', array('jquery','foundation','startup','magiclab'), $ver, true);
	}
	// L10n
	wp_localize_script(
		'magiclab',
		'MagicLabL10n',
		array(
			'all'          => esc_attr__('All','magiclab'),
			'showLess'     => esc_attr__('Show Less','magiclab'),
			'info' 	       => esc_attr__('Info','magiclab'),
			'showSynopsis' => esc_attr__('Show synopsis','magiclab'),
			'hideSynopsis' => esc_attr__('Hide synopsis','magiclab'),
		)
	);
	// Map
	// @todo is_admin() check needed?
	if ( is_page('contact') && ! is_admin() ) {
		wp_enqueue_script(
			'magiclab_gmap',
			get_stylesheet_directory_uri() . '/js/gmap.js',
			false, //no deps
			'0.13',
			true
		);
		wp_localize_script(
			'magiclab_gmap',
			'magiclab_gmap',
			array(
				'icon'   => get_stylesheet_directory_uri().'/images/star-black.png',
				'center' => array('50.0656163','14.4289533'),
				'zoom'   => 15,
			)
		);
	}
	if ( is_page('contact-bratislava') && ! is_admin() ) {
		wp_enqueue_script(
			'magiclab_gmap_sk',
			get_stylesheet_directory_uri() . '/js/gmap_sk.js',
			false, //no deps
			'0.13',
			true
		);
		wp_localize_script(
			'magiclab_gmap_sk',
			'magiclab_gmap_sk',
			array(
				'icon'   => get_stylesheet_directory_uri().'/images/star-black.png',
				'center' => array('48.1396722','17.2551808'),
				'zoom'   => 15,
			)
		);
	}
	if ( is_page('contact-warsaw') && ! is_admin() ) {
		wp_enqueue_script(
			'magiclab_gmap_pl',
			get_stylesheet_directory_uri() . '/js/gmap_pl.js',
			false, //no deps
			'0.13',
			true
		);
		wp_localize_script(
			'magiclab_gmap_pl',
			'magiclab_gmap_pl',
			array(
				'icon'   => get_stylesheet_directory_uri().'/images/star-black.png',
				'center' => array('52.2051642','21.0380800'),
				'zoom'   => 15,
			)
		);
	}
}
