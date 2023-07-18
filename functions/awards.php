<?php 

/**
 * Has award
 *
 * @todo find a better way how to reset the have_rows loop
 * @hack running have_rows twice helps with award not detected if post appears twice on the same page
 *
 * @return Bool whether $post or $post_id has any awards
 */
function magiclab_has_award($post_id=null) {
	global $post;
	if ( ! $post_id = absint($post_id) )
		$post_id = $post->ID;
	if ( ! $post_id )
		return false;
	if ( ! function_exists('have_rows') )
		return false;
	// if there is connected project get it's awards instead
	if ( $master_id = magiclab_get_master_project_id($post_id) ) {
		$post_id = $master_id;
	}
	// Awards v1
	$have_rows = have_rows('ml_project_awards',$post_id);
	while ( have_rows('ml_project_awards',$post_id) ) {
		the_row();
		// return true on the first non-empty award
		$award_text = get_sub_field('ml_project_award_title');
		if ( ! empty($award_text) ) {
			return true;
		}
	}
	// Awards v2
	while ( have_rows('ml_project_awards_v2',$post_id) ) {
		the_row();
		$award_rows = get_sub_field('ml_project_award_rows');
		if ( is_array($award_rows) && ! empty($award_rows) ) {
			foreach ( $award_rows as $award_row ) {
				// return true on the first non-empty award
				$award_text = wp_strip_all_tags($award_row['ml_project_award_text']);
				if ( ! empty($award_text) ) {
					return true;
				}
			}
		}
	}
	// nothing found, bail out
	return false;
}

/**
 * Register admin columns
 */
add_action('manage_mau_project_posts_columns','magiclab_project_columns');
add_action('manage_mau_finished_project_posts_columns','magiclab_project_columns');
function magiclab_project_columns($columns){
    //add new columns
    $columns['ml_project_awards'] = 'Awards';
    return $columns;
}

/**
 * Add content to admin columns
 */
add_action('manage_mau_project_posts_custom_column','magiclab_project_columns_content',10,2);
function magiclab_project_columns_content($column,$post_id){
	if ( ! function_exists('have_rows') )
		return false;
	if ( 'ml_project_awards' != $column  )
		return false;
	// if there is connected project get it's awards instead
	if ( $master_id = magiclab_get_master_project_id($post_id) ) {
		$post_id = $master_id;
	}
	// Awards v1
	if( have_rows('ml_project_awards', $post_id) ) {
		echo '<ul class="project-awards row">';
		while ( have_rows('ml_project_awards', $post_id) ) {
			the_row();
			echo '<li>';
		    the_sub_field('ml_project_award_title');
	        echo '</li>';
	    }
	    echo '</ul>';
	}
    // Awards v2
	if( have_rows('ml_project_awards_v2', $post_id) ) {
	    echo '<div class="project-awards row">';
        echo '<small>';
	    while ( have_rows('ml_project_awards_v2', $post_id) ) {
	    	the_row(); 
	        $award_rows = get_sub_field('ml_project_award_rows');
	        if ( is_array($award_rows) && ! empty($award_rows) ) {
	        	foreach ( $award_rows as $award_row ) {
	        		if ( 'bold' == $award_row['ml_project_award_weight'] ) echo '<strong>';
	        		// if ( 'normal' == $award_row['ml_project_award_size'] ) echo '<small>';
	        		echo wp_strip_all_tags($award_row['ml_project_award_text']).' ';
	        		// if ( 'normal' == $award_row['ml_project_award_size'] ) echo '</small>';
	        		if ( 'bold' == $award_row['ml_project_award_weight'] ) echo '</strong>';
	        	}
	        }
	        echo '<br/>';
	    }
	    echo '</small>';
	    echo '</div>';
	}
	// Connected
    if ( $master_id ) {
    	echo '<br/>';
    	$title = get_the_title($master_id);
		$title = esc_html($title);
    	$link  = current_user_can('edit_post', $master_id) ? get_edit_post_link($master_id) : false;
		if ( $link ) {
	    	$title = '<a href="'.esc_url($link).'">'.$title.'</a>';
		}
    	echo '<em>'.esc_html__('Source:','magiclab').' '.$title.'</em>';
    }
}

/**
 * Get awards count
 *
 * @since 1.3.95
 * @param int $post_id
 * @return int number of awards
 */
function magiclab_get_awards_count($post_id=null) {
	global $post;
	if ( ! $post_id )
		$post_id = $post->ID;
	if ( ! $post_id )
		return false;
	if ( ! function_exists('have_rows') )
		return false;
	// if there is connected project get it's awards instead
	if ( $master_id = magiclab_get_master_project_id($post_id) ) {
		$post_id = $master_id;
	}
	if ( ! $awards = get_field('ml_project_awards_v2', $post_id) )
		return false;
	return count($awards);
}
