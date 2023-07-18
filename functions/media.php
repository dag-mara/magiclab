<?php

/* IMAGE SIZES */
add_image_size( 'medium', 640, 360, array( 'center', 'top' ) );
set_post_thumbnail_size( 640, 360 );
add_image_size( 'tiny', 100, 57, array( 'center', 'top' ) );

/* GALLERIES */
remove_shortcode('gallery');
add_shortcode('gallery', 'magiclab_custom_size_gallery');
function magiclab_custom_size_gallery($attr) {
    // Change size here - medium, large, full
    if ( is_front_page() )
	    $attr['size'] = 'thumbnail';
	else
		$attr['size'] = 'medium';
    return gallery_shortcode($attr);
}