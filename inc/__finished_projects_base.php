<?php
/**
 * Generic Finished Projects Base Template
 *
 * Template for loading finished projects.
 * Loads all at once but displays only
 * featured projects on initial load.
 *
 * Expected variables from outer scope:
 * - $heading_text
 * - $number_of_featured
 * - $post_type
 * - $container_id
 * - $show_all_id
 *
 * @example set_query_var('number_of_featured', 16);
 *
 * @see finished_projects_ajaxified.php in case
 * there is a lot of finished projects
 * and performance needs to be improved
 *
 */




//echo $number_of_featured;
$args = array(
	'post_type'      => $post_type,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'posts_per_page' => $number_of_featured
);

$posts = get_posts($args);

?>
<div id="<?php echo esc_attr($container_id); ?>" class="row">
	<h2><?php esc_html_e($heading_text, 'magiclab'); ?></h2>

	<?php
	foreach($posts as $post){
		setup_postdata($post);
		$i++;
		$dir = $i > 4 ? 'right' : 'left';
		/*
		$classes = '';
		$feat_classes = '';
		$is_feat = get_post_meta($post->ID, '_mau_feat_lite', true);
		if ( $is_feat || $no_of_posts_to_add > 0 ) {
			$feat_i++;
			$feat_dir = $feat_i > 4 ? 'right' : 'left';
			if ( $feat_i >= 8 ) $feat_i = 0;
			$feat_classes .= ' finished-project-'.$feat_dir.'-feat';
			$classes .= ' finished-project-featured';
			if ( ! $is_feat )
				$no_of_posts_to_add--;
		}
		echo $classes;
		*/
	?>
	<div class="finished-project finished-project-featured" data-project-id="<?php the_ID(); ?>">
		<a href="#info">
			<?php
				//the_post_thumbnail('thumbnail');
				$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()  ), "thumbnail" );
				// add more attributes if you need
				//printf( '<img data-src="%s" class="lazyload"/>', esc_url( $thumbnail_src[0] ) );
			?>
			<img src="https://magiclab.grafique.cz/wp-content/themes/magiclab-theme/images/loader.svg" data-src="<?=$thumbnail_src[0]?>" class="lazyload" />
			<?php do_action('magiclab_project_badge'); ?>
		</a>
		<div class="finished-project-info finished-project-<?php echo $dir; ?> <?php //echo esc_attr($feat_classes); ?> finished-project-pt-<?php //echo esc_attr($post_type); ?>" data-info-id="<?php the_ID(); ?>">
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
	<?
	}
	?>
</div>
<?php




?>
