	<?php

	$is_client_project = is_post_type_archive('mau_clients_project') || is_tax('mau_clients_projects_category') || is_singular('mau_clients_project');

	if ( $is_client_project ) {
		do_action('mau_clients_project_client_select');
	} else {
		get_template_part('inc/project_tax_list');
	}
	?>

	<div class="row projects-container">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article <?php post_class(); ?> id="<?php echo esc_attr( $post->post_name ); ?>">
				<div class="inner row">

					<div class="video columns medium-7 medium-push-5 large-8 large-push-4">
						<div class="video-inner">
							<?php
							//echo 1;

							//$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ) , "large" );
							//print_r($thumbnail_src);
							the_post_thumbnail('large')
							?>
							<a href="#" class="play_button">
								<img width="140" height="140" title="" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/magic_lab_PLAY.png" />
							</a>
							<?php do_action('magiclab_vdo_post_player'); ?>
						</div>
						<?php if ( $is_client_project ) magiclab_download_link(); ?>
					</div>

					<div class="entry column medium-5 medium-pull-7 large-4 large-pull-8">
						<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
						<?php do_action( $is_client_project ? 'mau_clients_project_client' : 'magiclab_project_tax_link' ); ?>
						<?php the_content(); ?>
						<?php do_action('magiclab_synopsis'); ?>
						<?php if ( ! $is_client_project ) get_template_part('inc/awards'); ?>
					</div>
				</div>
			</article>

		<?php endwhile; else: ?>
		<?php // _e('Sorry, the page you requested was not found','startup'); ?>
		<?php endif; ?>
	</div>
