<?php
/**
 * Featured Slider Template
 *
 * @see startup5/inc/fetured.php
 *
 */

$play = get_stylesheet_directory_uri().'/images/magic_lab_PLAY2x.png';
$opt  = get_option('startup_theme_options');
$args = apply_filters('startup_feat_slider_args', array('post_type'=>'post'));
$loop = new WP_Query($args);
$size = 'large';
?>

<div class="row">
	<div class="large-12 columns featured-slider">
		<div id="featured" data-orbit <?php startup_orbit_options(); ?>>

			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

				<div class="slide">

					<?php if ( $img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),$size) ) : ?>

						<div class="slide-bg-img" style="background-image:url(<?php esc_attr_e($img[0]); ?>);"></div>

					<?php endif; ?>

					<a href="#" class="play_button" <?php magiclab_video_data_attr($post->ID); ?> >
						<img width="140" height="140" title="" alt="" src="<?php echo $play; ?>" />
					</a>

					<h2 class="video-slide-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>

					<?php do_action('magiclab_award_icon',$post->ID); ?>

				</div>
			<?php endwhile; ?>

			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</div>
