<?php



add_action( 'after_setup_theme', 'magiclab_theme_init', 10 );
function magiclab_theme_init() {


	/* INIT */
	include_once('functions/init.php');

	/* ASSETS */
	include_once('functions/assets.php');

	/* MEDIA */
	include_once('functions/media.php');

	/* TEMPLATE TAGS */
	include_once('functions/template_tags.php');

	/* PROJECTS */
	include_once('functions/projects.php');

	/* AWARDS */
	include_once('functions/awards.php');

	/* TEAM */
	include_once('functions/team.php');

	/* UTILS */
	include_once('functions/utils.php');

	include_once('inc/ajax-call.php');

	/* ADMIN */
	if ( is_admin() ) {
		include_once('functions/admin.php');
	}

	/* DEBUGGING */
	if ( WP_DEBUG && current_user_can('update_core') ) {
		include_once('functions/debug.php');
	}

}
/*
add_filter( 'wp_get_attachment_image_attributes', 'wpse8170_add_lazyload_to_attachment_image', 10, 2 );
function wpse8170_add_lazyload_to_attachment_image( $attr, $attachment ) {
    $attr['data-original'] = $attr['src'];
    $attr['src'] = 'grey.gif';
    return $attr;
}
*/



/*
function lazyload_image( $html ) {
    $html = str_replace( 'src=', 'data-src=', $html );
	echo $html;
    return $html;
}

add_filter( 'the_post_thumbnail', 'lazyload_image');
*/

function remove_cssjs_ver( $src ) {
    if( strpos( $src, '?ver=' ) )
        $src = remove_query_arg( 'ver', $src );

    if( strpos( $src, '?v=' ) )
        $src = remove_query_arg( 'v', $src );

    return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 1000 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 1000 );

function my_custom_menu() {
    register_nav_menu('jobs-menu',__( 'Jobs menu' ));
}
add_action( 'init', 'my_custom_menu' );

function my_custom_menu_contact() {
    register_nav_menu('contact-menu',__( 'Contact menu' ));
}
add_action( 'init', 'my_custom_menu_contact' );