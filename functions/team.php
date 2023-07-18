<?php

// Disable team archive
add_filter( 'mau_team_pt_args', 'magiclab_team_pt_args' );
function magiclab_team_pt_args($args) {
	$args['has_archive'] = false;
	return $args;
}

// Team redirects
add_action( 'template_redirect', 'magiclab_team_redirects' );
function magiclab_team_redirects() {
	// @todo REDIRECT CHILDPAGES
	// $child_pages = get_pages( 'nopaging=1&child_of='.get_the_ID() ); // we need homepage id here
	// if ( in_array(  ) )
	if ( is_singular('mau_team') || is_post_type_archive('mau_team') ) {
		wp_redirect('/contact/');
		exit;
	}
}