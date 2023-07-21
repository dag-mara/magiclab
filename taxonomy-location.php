<?php get_header(); ?>
<div class="jobs-menu">
    <?php // Jobs navigation
    
    add_action('startup_nav_bar_jobs','startup_nav_bar_jobs');
		function startup_nav_bar_jobs(){

			if ( ! has_nav_menu( 'jobs-menu' ) )
				return false;

			wp_nav_menu( array(
				'theme_location'  => 'jobs-menu',
				'container'       => 'nav',
				'menu_class'      => 'nav-bar',
			) );
		};
        
        startup_nav_bar_jobs();?>
</div>

<div class="row jobs-header">
	<h1 class="text-center">Jobs</h1>
</div>

<div class="row jobs" id="jobs-container">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article class="small-12 columns job-card" <?php post_class(); ?> >

			<div class="inner">
				<hr>
				<div class="grid-x">
					<div class="small-12 medium-5">
						<a class="thumb-link" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
					</div>
					<div class="small-11 medium-7 grid-x">
						<a class="grid-x" href="<?php the_permalink(); ?>">
							<div class="small-7">
							<h2><?php the_title(); ?></h2>
								<p><?php the_excerpt(); ?></p>
								<!-- <div class="project-tax-link">
									<?php $terms = get_the_terms( $post->ID , 'location' );
									foreach ( $terms as $term ) {
									echo $term->slug . " ";
									}
									?>
								</div> -->
							</div>
							<div class="small-5 text-right">
							→
							</div>
						</a>
					</div>
				</div>
				
			</div>

		</article>

	<?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>