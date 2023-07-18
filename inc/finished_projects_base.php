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


$args = array(
	'post_type'      => $post_type,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'posts_per_page' => -1,
);

$all_posts = get_posts($args);
$all_count = count($all_posts);

$feat_args = array(
	'meta_key'       => '_mau_feat_lite',
	'fields'         => 'ids',
	'posts_per_page' => $number_of_featured,
);
$feat_posts_ids = get_posts(wp_parse_args($feat_args, $args));
$feat_count = count($feat_posts_ids);
$no_of_posts_to_add = $feat_args['posts_per_page'] - $feat_count;
?>

<div id="<?php echo esc_attr($container_id); ?>" class="row">

	<?php if(!isset($info_wrapper_rendered)): $info_wrapper_rendered=true; ?>
		<div id="info-wrapper"></div>
	<?php endif; ?>

	<?php if ($all_count): ?>
		<h2><?php esc_html_e($heading_text, 'magiclab'); ?></h2>
	<?php endif; ?>

	<?php
	$all_posts = the_finished_projects_m($post_type);

	$i=0;
	$feat_i=0;
	?>
	<div class="data-projects">
	<?php
	foreach ( $all_posts as $post ) :
		setup_postdata($post);
		if ( ! has_post_thumbnail() )
			continue;
		$i++;
		$dir = $i > 4 ? 'right' : 'left';
		if ( $i >= 8 ) $i = 0;
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
	?>
	<div class="finished-project <?php echo esc_attr($classes); ?>" data-project-id="<?php the_ID(); ?>">
		<!-- <a href="#info" class="viewDetail"> -->
		<a class="viewDetail" data-id="<?=get_the_ID();?>">
			<?php
				//the_post_thumbnail('thumbnail');
				$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()  ), "thumbnail" );
				// add more attributes if you need
				//printf( '<img data-src="%s" class="lazyload"/>', esc_url( $thumbnail_src[0] ) );
			?>
			<img src="<?=$thumbnail_src[0]?>" data-src="" class="" />
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
	<?php endforeach; ?>
	</div>
	<?php wp_reset_query(); ?>
	<?php if ( $all_count > $feat_args['posts_per_page'] ) : ?>
		<div class="columns small-12 more-link">
			<a class="magic-button viewMore" data-page-type="<?=$post_type?>"><?php esc_html_e('All', 'magiclab'); ?></a>
			<!--
			<a class="magic-button" id="<?php echo esc_attr($show_all_id); ?>" href="<?php echo get_post_type_archive_link($post_type); ?>"><?php esc_html_e('All', 'magiclab'); ?></a>
			-->
		</div>
	<?php endif; ?>
</div>
