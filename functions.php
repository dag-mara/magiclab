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


add_filter('relevanssi_search_filters','magiclab_relevanssi_filters', 10, 1);
function magiclab_relevanssi_filters( $args ) {
// Only if checkbox is checked
	//if ( $_POST['only_finished_projects']) { 
		if (isset($_GET['only_finished_projects'])) {
	
	// Change the array of post types
		$args['post_type'] = array('mau_finished_project');
	} 
return $args;
}

add_filter( 'the_posts', function( $posts, $q ) 
{
    if( $q->is_main_query() && $q->is_search() ) 
    {
        usort( $posts, function( $a, $b ){
            /**
             * Sort by post type. If the post type between two posts are the same
             * sort by post date. Make sure you change your post types according to 
             * your specific post types. This is my post types on my test site
             */
            $post_types = [
                'mlab_finished_series' => 1,
                'mau_project'       => 2,
                'mau_finished_project'    => 3
            ];              
            if ( $post_types[$a->post_type] != $post_types[$b->post_type] ) {
                return $post_types[$a->post_type] - $post_types[$b->post_type];
            } else {
                return $a->post_date < $b->post_date; // Change to > if you need oldest posts first
            }
        });
    }
    return $posts;
}, 10, 2 );