<?php
add_action('wp_ajax_works_more', 'works_more_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_works_more', 'works_more_ajax_handler'); // wp_ajax_nopriv_{action}
function works_more_ajax_handler() {
	//global $post;
	ob_start();
	//echo 'fd';
	$argRet['html'] = '';

	$argRet['paged'] = '';

	$nr = the_works_data_count();
	if($nr > 0 ) $nr = ceil($nr / 9);
	if($nr > 0 && ($_POST['paged']+1) < $nr){
		$argRet['paged'] = $_POST['paged']+1;
	}
	the_works_data();

	$html = ob_get_clean();

	$argRet['html'] = $html;
	$argRet['count'] = $nr;

    wp_send_json($argRet);
	//wp_send_json_success( 'It works' );
}


add_action('wp_ajax_finished_more', 'the_finished_movies_serials_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_finished_more', 'the_finished_movies_serials_ajax_handler'); // wp_ajax_nopriv_{action}
function the_finished_movies_serials_ajax_handler() {
	global $post;

	$limit = 16;
	if(stristr($_POST['pagetype'],'mlab_finished_series')){
		$limit = 8;
	}

	$argRet = array();
	$args = array(
	   'meta_key'       => '_mau_feat_lite',
	   'fields'         => 'ids',
	   'post_type'      => $_POST['pagetype'],
	   'orderby'        => 'menu_order',
	   'order'          => 'ASC',
	   'posts_per_page' => 16
   );

   $featured = get_posts($args);
   $cFeatured = count($featured);

   if($cFeatured > 0){
	   $argRet = $featured;
   }
   ob_start();
   if($cFeatured < $limit){
	   $sum = ($limit - $cFeatured);
	   $args = array(
	   	   'post_type'      => $_POST['pagetype'],
	   	   'orderby'        => 'menu_order',
	   	   'order'          => 'ASC',
		   'fields'         => 'ids',
	   	   'posts_per_page' => $sum,
	      );
	   $all = get_posts($args);

	   if(count($all) > 0) $argRet = array_merge($argRet,$all);
   }

   $args = array(
	   'post_type'      => $_POST['pagetype'],
	   'orderby'        => 'menu_order',
	   'order'          => 'ASC',
	   'post__not_in'   => $argRet,
	   'posts_per_page' => -1,
	  );
	$argData = get_posts($args);



	if(!empty($argData)){
		$i=0;
		$feat_i=0;
		foreach ( $argData as $post ) :
			setup_postdata($post);
			if ( ! has_post_thumbnail() )
				continue;
			$i++;
			$dir = $i > 4 ? 'right' : 'left';
			if ( $i >= 8 ) $i = 0;
			$classes = '';
			$feat_classes = '';
			$is_feat = true;
			if ( $is_feat || $no_of_posts_to_add > 0 ) {
				$feat_i++;
				$feat_dir = $feat_i > 4 ? 'right' : 'left';
				if ( $feat_i >= 8 ) $feat_i = 0;
				$feat_classes .= ' finished-project-'.$feat_dir.'-feat';
				$classes .= ' finished-project-featured';
				if ( ! $is_feat )
					$no_of_posts_to_add--;
			}
		?>
		<div class="finished-project <?php echo esc_attr($classes); ?>" data-project-id="<?php the_ID(); ?>">
			<a href="#info">
				<?php
					//the_post_thumbnail('thumbnail');
					$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()  ), "thumbnail" );
					// add more attributes if you need
					//printf( '<img data-src="%s" class="lazyload"/>', esc_url( $thumbnail_src[0] ) );
				?>
				<!-- <img src="https://magiclab.grafique.cz/wp-content/themes/magiclab-theme/images/loader.svg" data-src="<?=$thumbnail_src[0]?>" class="lazyload" /> -->
				<img src="<?=$thumbnail_src[0]?>" />
				<?php do_action('magiclab_project_badge'); ?>
			</a>
			<div class="finished-project-info finished-project-<?php echo $dir; ?> <?php echo esc_attr($feat_classes); ?> finished-project-pt-<?php echo esc_attr($post_type); ?>" data-info-id="<?php the_ID(); ?>">
				<div class="inner">
					<h3><?php the_title(); ?></h3>
					<?php the_content(); ?>
					<?php get_template_part('inc/awards'); ?>
					<?php do_action('magiclab_trailer_link', $post->ID); ?>
					<?php do_action('magiclab_vfx_link', $post->ID); ?>
					<span class="info-close"></span>
				</div>
			</div>
		</div>
		<?php
		endforeach;
	}
	$html = ob_get_clean();

	$argRet['html'] = $html;

    wp_send_json($argRet);
	//wp_send_json_success( 'It works' );
}

add_action('wp_ajax_finished_detail', 'the_finished_detail_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_finished_detail', 'the_finished_detail_ajax_handler'); // wp_ajax_nopriv_{action}
function the_finished_detail_ajax_handler() {
	ob_start();
	?>
	<div class="finished-project-info finished-project-left  finished-project-left-feat finished-project-pt-mau_finished_project active" data-info-id="5996">
		<div class="inner">
			<h3>Charlatan</h3>
			<p>Biopic / Drama / 118min / 2020</p>
			<p>Czech Republic / Ireland / Slovakia / Poland</p>
			<p>Production: Marlene Film Production (Šárka Cimbalová, Kevan Van Thompson)<br>
			Director: Agnieszka Holland<br>
			DoP: Martin Štrba<br>
			Edit: Pavel Hrdlička<br>
			Co-production: Magic Lab</p>
			<p><strong>VFX&nbsp;</strong></p>
			<p>Charlatan tells a story about an almost forgotten Czech healer, and an unusual medicine man, Jan Mikolášek who cured millions even as he suffered under both Nazi and Communist rule.</p>
			<a class="trailer-link trailer-link-project-lightbox magic-button" href="https://magiclab.grafique.cz/projects/movies/#charlatan-trailer" data-video-id="390032398" data-video-provider="vimeo">View Trailer</a>								<span class="info-close"></span>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	$argRet['html'] = $html;

    wp_send_json($argRet);
}