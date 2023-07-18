<?php

function magiclab_video_data_attr($post_id=null) {
	if ( ! $post_id )
		$post_id = get_the_ID();
	echo magiclab_get_video_data_attr($post_id);
}

// @todo DRY, use plugin's method instead
function magiclab_get_video_data_attr($post_id=null) {
	if ( ! $post_id )
		return '';
	$url = get_post_meta( $post_id, '_mau_tube_lite_url', true);
	if ( ! $url )
		return '';
	if ( false !== strpos($url, 'vimeo') ) {
		$video_id = filter_var($url, FILTER_SANITIZE_NUMBER_INT);
		$provider = 'vimeo';
	} 
	elseif ( false !== strpos($url, 'youtube') ) {
		parse_str(parse_url($url, PHP_URL_QUERY), $query_vars);
		$video_id = array_key_exists('v', $query_vars) ? $query_vars['v'] : '';
		$provider = 'youtube';
	}
	elseif ( false !== strpos($url, 'youtu.be')  ) {
		$video_id = trim(parse_url($url, PHP_URL_PATH), '/');
		$provider = 'youtube';
	}
	else {
		return '';
	}		
	if ( ! $video_id )
		return '';
	return sprintf(
		'data-video-id="%s" data-video-provider="%s" ', 
		esc_attr($video_id), 
		esc_attr($provider)
	);
}

/**
 * Get master project ID
 * 
 * @since 1.4.3x
 * @param int $post_id
 * @return bool|int $master_id on succes, false on fail
 */
function magiclab_get_master_project_id($post_id) {
	// disabled for now
	return false;
	if ( ! function_exists('get_field') )
		return false;
	if ( ! $master_id = get_field('magiclab_master_project',$post_id) )
		return false;
	return $master_id;
}


/**
 * Project post class
 *
 */
add_action('post_class','magiclab_projects_columns');
function magiclab_projects_columns($classes) {

	if ( ! is_post_type_archive('mau_project') && ! is_post_type_archive('mau_clients_project') )
		return $classes;

	$classes[] = 'columns';
	$classes[] = 'medium-4';

	if ( ! taxonomy_exists( 'mau_project_tax' ) )
		return $classes;
	$term_ids = wp_get_object_terms( get_the_ID(), 'mau_project_tax', array('fields'=>'ids') );
	if ( ! $term_ids || is_wp_error( $term_ids ) )
		return $classes;
	foreach ( $term_ids as $term_id )
		$classes[] = 'in-tax-'.$term_id;

	return $classes;
}


/**
 * Project Tax Link
 *
 */
add_action('magiclab_project_tax_link','magiclab_project_tax_link');
function magiclab_project_tax_link() {
	$term = wp_get_object_terms( get_the_ID(), 'mau_project_tax' );
	if ( ! $term || is_wp_error( $term ) )
		return false;
	$term = reset($term);
	echo '<a class="project-tax-link" href="'.get_term_link( $term ).'">'.$term->name.'</a>';
}


/**
 * Project Share Link
 *
 */
add_action('magiclab_project_share_link','magiclab_project_share_link');
function magiclab_project_share_link() {
	$url = add_query_arg(
		array( 'u',urlencode(get_permalink()) ),
		'http://www.facebook.com/sharer/sharer.php'
	);
	echo '<a target="_blank" class="project-share-link icon-heart" href="'.esc_url($url).'">Share</a>';
}


/** 
 * Change projects admin icons
 *
 */
add_filter( 'mau_projects_pt_args', 'magiclab_projects_pt_args' );
function magiclab_projects_pt_args($args) {
	$args['menu_icon'] = 'dashicons-video-alt3';
	return $args;
}
add_filter( 'mau_clients_projects_pt_args', 'magiclab_clients_projects_pt_args' );
function magiclab_clients_projects_pt_args($args) {
	$args['menu_icon'] = 'dashicons-format-video';
	$args['menu_position'] = 2;
	return $args;
}


/** 
 * Redirect single project to taxonomy archive + hash tag
 *
 */
add_action( 'template_redirect', 'magiclab_project_redirects' );
function magiclab_project_redirects() {
	if ( ! is_singular('mau_project') && ! is_singular('mau_clients_project') )
		return false;
	global $post;
	if ( ! $url = magiclab_get_project_url($post) )
		return false;
	wp_redirect( $url );
	exit;
}


/** 
 * Filter single project link to taxonomy archive + hash tag
 * 
 */
add_filter( 'post_type_link', 'magiclab_change_permalinks', 10, 2);
function magiclab_change_permalinks($permalink, $post ) {
	if ( ! in_array( $post->post_type, array('mau_project','mau_clients_project') ) )
		return $permalink;
	if ( ! $url = magiclab_get_project_url($post) )
		return $permalink;
    return $url;
}


/**
 * Get project URL
 *
 * Helper to get project url in above filters
 *
 */
function magiclab_get_project_url($post) {
	if ( ! $post->ID )
		return false;
	$taxonomy = 'mau_project' == $post->post_type ? 'mau_project_tax' : 'mau_clients_projects_category';
	if ( ! taxonomy_exists($taxonomy) )
		return false;
	$terms = wp_get_object_terms( $post->ID, $taxonomy, array(
		'fields'   => 'slugs',
		'order_by' => 'term_id',
		'order'    => 'ASC',
	) );
	if ( empty($terms) )
		return false;
	$url  = get_post_type_archive_link($post->post_type);
	$url .= $terms[0].'/';
	if ( isset($_GET['user_id']) && absint($_GET['user_id']) )
		$url = add_query_arg('user_id',$_GET['user_id'],$url);
	$url .= '#'.$post->post_name;
	return $url;
}


/** 
 * Request Filter
 *
 */
add_filter( 'request', 'magiclab_project_tax_request' );
function magiclab_project_tax_request($request) {

	if ( is_admin() )
		return $request;

    $dummy_query = new WP_Query();
    $dummy_query->parse_query( $request );

	// Show all projects on main projects archive
	// Don't show finished projects in the main archive
    if ( $dummy_query->is_post_type_archive('mau_project') ) {
	    $request['nopaging']  = true;
		$request['tax_query'] = array(
			array(
				'taxonomy' => 'mau_project_tax',
				'field'    => 'slug',
				'terms'    => array('finished'),
				'operator' => 'NOT IN',
			),
		);
    }

	// Show all projects on projects taxonomy archive
    if ( $dummy_query->is_tax('mau_project_tax') ) {
		$request['nopaging'] = true;
		$request['orderby']  = 'menu_order';
		$request['order']    = 'ASC';
    }

	return $request;
}


/** 
 * Remove title attribute from taxonomy listing
 *
 */
add_filter('wp_list_categories', 'magiclab_remove_tax_list_titles');
function magiclab_remove_tax_list_titles($output) {
    $output = preg_replace('` title="(.+)"`', '', $output);
    return $output;
}


/**
 * Show project thumbnails in admin
 *
 */
add_filter('mau_projects_options', 'magiclab_mau_projects_options');
add_filter('mau_clients_projects_options', 'magiclab_mau_projects_options');
add_filter('mau_finished_projects_options', 'magiclab_mau_projects_options');
add_filter('magiclab_finished_series_options', 'magiclab_mau_projects_options');
function magiclab_mau_projects_options($options) {
    $options['image_column'] = 'tiny';
    return $options;
}


/** 
 * Finished projects body class
 *
 */
add_filter('body_class', 'magiclab_finished_projects_body_class');
function magiclab_finished_projects_body_class($classes) {
	if ( is_home() || is_front_page() )
		$classes[] = 'finished-projects-collapsed';
		$classes[] = 'finished-series-collapsed';
	return $classes;
}


/**
 * Project Badge
 *
 */
add_action('magiclab_project_badge','magiclab_project_badge');
function magiclab_project_badge() {
	$badge = get_field('magiclab_project_badge');
	if ( $badge && $badge == 'in-production' )
		echo '<span class="project-badge project-badge-in-production">'.esc_attr__('In Production', 'magiclab').'</span>';
}
