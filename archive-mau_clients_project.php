<?php get_header(); ?>

	<?php do_action('mau_clients_project_client_select'); ?>

	<div class="row projects" id="projects-container">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article <?php post_class(); ?> >

				<div class="inner">

					<a class="thumb-link" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>

					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

					<div class="project-tax-link">
						<?php do_action('mau_clients_project_client'); ?>
					</div>

				</div>

			</article>

		<?php endwhile; ?>
		<?php else: ?>
			<div class="columns small-12 no-posts">No projects</div>;
		<?php endif; ?>
	</div>

<?php get_footer(); ?>