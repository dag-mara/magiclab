	<?php // get_template_part('inc/project_tax_list'); ?>

	<div class="row projects-container">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article <?php post_class(); ?> id="<?php echo esc_attr( $post->post_name ); ?>">

				<div class="inner row">

					<div class="entry column medium-4">

						<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>

						<?php do_action('mau_clients_project_client'); ?>

						<?php the_content(); ?>

						<?php // do_action('magiclab_project_share_link'); ?>

					</div>

					<div class="video columns medium-8">
						<div class="video-inner">
						<?php the_post_thumbnail('large') ?>
						<a href="#" class="play_button">
							<img width="140" height="140" title="" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/magic_lab_PLAY.png" />
						</a>
						</div>
					</div>

				</div>

				<?php magiclab_download_link(); ?>

			</article>

		<?php endwhile; else: ?>

		<?php // _e('Sorry, the page you requested was not found','startup');?>

		<?php endif; ?>
	</div>