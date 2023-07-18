<?php

/**
 * Display project synopsis
 *
 * @since 1.5.0
 *
 * @todo only for movies cat
 * @todo only on single
 *
 */
add_action('magiclab_synopsis','magiclab_project_synopsis');
function magiclab_project_synopsis($post_id=null) {
	global $post;
	if ( ! $post_id )
		$post_id = $post->ID;
	if ( ! $post_id )
		return false;
	if ( ! function_exists('get_field') )
		return false;
	$synopsis_content = get_field('magiclab_project_synopsis_content', $post_id);
	if ( empty($synopsis_content) )
		return false;
	$synopsis_hide = get_field('magiclab_project_synopsis_hide', $post_id);
	$is_movies_cat = is_tax('mau_project_tax', 'movies');
	// $is_movies_cat = magiclab_is_cat_movies($post_id);
	if ( $is_movies_cat && $synopsis_hide ) {
		$text = 'Show synopsis';
		$classes = 'hidden hidden-by-default';
	} else {
		$text = 'Hide synopsis';
		$classes = '';
	}
	if ( $is_movies_cat ) {
		echo '<a href="#synopsis" class="project-synopsis-trigger magic-plus-button button-plus-to-minus">'.esc_html__($text, 'magiclab').'</a>';
	}
	echo '<div class="project-synopsis '.esc_attr($classes).'">'.$synopsis_content.'</div>';
}


/**
 * Award icon with count
 *
 * @since 1.3.95
 * @param int $post_id
 * @return void
 */
add_action('magiclab_award_icon', 'magiclab_award_icon');
function magiclab_award_icon($post_id=null) {
	global $post;
	if ( ! $post_id )
		$post_id = $post->ID;
	if ( ! $post_id )
		return;
	if ( ! $awards_count = magiclab_get_awards_count($post_id) )
		return;
	$dir = get_stylesheet_directory_uri().'/images';
	echo '<span class="award-icon"><img src="'.$dir.'/award_icon2x.png" srcset="'.$dir.'/award_icon.png 1x, '.$dir.'/award_icon2x.png 2x" alt="Award icon" /><span class="awards-count">'.$awards_count.'</span></span>';
}


/**
 * Project Download link
 *
 * @param int $post_id
 * @return void
 */
function magiclab_download_link($post_id=null) {
	global $post;
	if ( ! $post_id )
		$post_id = $post->ID;
	if ( ! $post_id )
		return false;
	if ( ! function_exists('get_field') )
		return false;
	if ( ! $link = get_field('ml_project_download_url', $post_id) )
		return false;
	echo '<a class="project-download-button magic-button" href="'.esc_url($link).'">'.esc_html__('Download Video', 'magiclab').'</a>';

}

/**
 * Project Trailer link
 *
 * @param int $post_id
 * @return void
 */
add_action('magiclab_trailer_link', 'magiclab_trailer_link', 10, 1);
function magiclab_trailer_link($post_id=null) {
	if ( ! $post_id ) {
		return false;
	}
	$extra_attrs = '';
	$link = get_post_meta( $post_id, 'mlab_fin_project_trailer', true );
	if ( ! in_array($link, array('project','url')) )
		return false;
	switch ($link) {
		case 'project':
			$project_id = absint(get_post_meta($post_id, 'mlab_fin_project_trailer_post', true));
			if ( ! $project_id )
				return false;
			$link = get_permalink( $project_id );
			$extra_class = 'trailer-link-project';
			if ( ! class_exists('MauTubeLite') ) {
				break;
			}
			$extra_attrs = magiclab_get_video_data_attr($project_id);
			if ( ! $extra_attrs ) {
				break;
			}
			$extra_class = 'trailer-link-project-lightbox';
			break;
		case 'url':
			$extra_attrs = 'target="_blank" ';
			$extra_class = 'trailer-link-url';
			$link = get_post_meta($post_id, 'mlab_fin_project_trailer_url',true);
			break;
	}
	echo '<a class="trailer-link '.esc_attr($extra_class).' magic-button" href="'.esc_url($link).'" '.$extra_attrs.' >View Trailer</a>';
}

/**
 * Project VFX Breakdown link
 *
 * @todo  DRY
 *
 * @param int $post_id
 * @return void
 */
add_action('magiclab_vfx_link', 'magiclab_vfx_link', 10, 1);
function magiclab_vfx_link($post_id=null) {
	if ( ! $post_id ) {
		return false;
	}
	$extra_attrs = '';
	$link = get_post_meta( $post_id, 'mlab_fin_project_vfx', true );
	if ( ! in_array($link, array('project','url')) ) {
		return false;
	}
	switch ($link) {
		case 'project':
			$project_id = absint(get_post_meta($post_id, 'mlab_fin_project_vfx_post', true));
			if ( ! $project_id ) {
				return false;
			}
			$link = get_permalink($project_id);
			$extra_class = 'vfx-link-project';
			if ( ! class_exists('MauTubeLite') ) {
				break;
			}
			$extra_attrs = magiclab_get_video_data_attr($project_id);
			if ( ! $extra_attrs ) {
				break;
			}
			$extra_class = 'vfx-link-project-lightbox';
			break;
		case 'url':
			$extra_attrs = 'target="_blank" ';
			$extra_class = 'vfx-link-url';
			$link = get_post_meta($post_id, 'mlab_fin_project_vfx_url',true);
			break;
	}
	echo '<a class="vfx-link '.esc_attr($extra_class).' magic-button" href="'.esc_url($link).'" '.$data.' >VFX Breakdown</a>';
}


function the_works_data_count(){
	$filter2 = '';
	$filter = array(
						'taxonomy' => 'mau_project_tax',
						'field'    => 'slug',
						'terms'    => array('finished'),
						'operator' => 'NOT IN',
					);
	if(isset($_POST['tax']) && !empty($_POST['tax'])){
		$filter2 = array(
						'taxonomy' => 'mau_project_tax',
						'field'    => 'slug',
						'terms'    => array($_POST['tax'])
					);
	}
	if(!empty($filter2)){
		$filter = array(
				        'relation' => 'AND',
				        $filter,
				        $filter2,
				  );
	}else{
		$filter = array($filter);
	}

	$posts = get_posts( array(
				'numberposts' => -1,
				'post_type'   => 'mau_project',
				'post_status' => 'publish',
				'tax_query' => $filter,
				),
			);
	return count($posts);
}

function the_works_data(){
	$paged   = $_POST['paged'];
	$filter2 = '';
	$filter = array(
						'taxonomy' => 'mau_project_tax',
						'field'    => 'slug',
						'terms'    => array('finished'),
						'operator' => 'NOT IN',
					);
	if(isset($_POST['tax']) && !empty($_POST['tax'])){
		$filter2 = array(
						'taxonomy' => 'mau_project_tax',
						'field'    => 'slug',
						'terms'    => array($_POST['tax'])
					);
	}
	if(!empty($filter2)){
		$filter = array(
				        'relation' => 'AND',
				        $filter,
				        $filter2,
				  );
	}else{
		$filter = array($filter);
	}

	query_posts( array(
				'posts_per_page' => 9,
				'post_type'   => 'mau_project',
				'paged'      => $paged+1,
				'orderby' => 'menu_order',
				'order'   => 'ASC',
				'post_status' => 'publish',
				'tax_query' => $filter,
	));
	if ( have_posts() ) : while ( have_posts() ) : the_post();
	?>
		<article <?php post_class(); ?> >
			<div class="inner">
				<a class="thumb-link" href="<?php the_permalink(); ?>">
					<?php
						//the_post_thumbnail('thumbnail');
						$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()  ), "medium" );
						if(!empty($thumbnail_src[0]) || is_file($thumbnail_src[0])){
						?>
						<img src="<?=$thumbnail_src[0]?>" class="lazyload" />
						<?php
						}else{
							the_post_thumbnail('medium');
						}
					?>
				</a>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php do_action('magiclab_project_tax_link'); ?>
				<?php do_action('magiclab_award_icon'); ?>
			</div>
		</article>
	<?php
	endwhile; endif;
}

function the_finished_projects_m($post_type){
	$argRet = array();

	$args = array(
	   'meta_key'       => '_mau_feat_lite',
	   'post_type'      => $post_type,
	   'orderby'        => 'menu_order',
	   'order'          => 'ASC',
	   'posts_per_page' => 16
   );
   $featured = get_posts($args);
   $cFeatured = count($featured);
   if($cFeatured > 0){
	   $argRet = $featured;
   }
   if($cFeatured < 16){
	   $sum = (16 - $cFeatured);
	   $args = array(
	   	   'post_type'      => $post_type,
	   	   'orderby'        => 'menu_order',
	   	   'order'          => 'ASC',
	   	   'posts_per_page' => $sum,
	      );
	   $all = get_posts($args);
	   if(count($all) > 0) $argRet = array_merge($argRet,$all);
   }

   return $argRet;
}
