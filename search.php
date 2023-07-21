<?php
/*
Template Name: Search Page
*/
?>
<?php get_header(); ?>

<div class="search-results-section grid-container">
	<div class="grid-x">

		<!-- Search results -->
		<div class="search-results row projects">

		<?php echo '<h3 class="search-column">' . $wp_query->found_posts . ' results for <span class="grey">' . get_search_query() . '</span></p>'; ?>

		<?php if ( have_posts() ) : // If some posts available
			while ( have_posts() ) : the_post(); // Posts loop ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('index-card columns medium-4'); ?>>
					<div class="entry-content grid-x">
						<figure class="small-12"><a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) {the_post_thumbnail('large'); } ?></a></figure>
						<div class="small-9 grid-x align-middle search-text">
							<header>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							</header>
						<!-- 	<?php the_excerpt(); ?> -->
						</div>
					</div>
				</article>

				

			<?php endwhile; // End of posts loop
		else : // If no posts ?>

			<!-- <article id="post-0" class="post no-results not-found search-column">
				<header>
					<h2><?php _e( 'Nic nenalezeno', 'starter' ); ?></h2>
				</header>
				<div class="entry-content">
					<p><?php _e( 'Nebyly nalezeny žádné příspěvky.', 'starter' ); ?></p>
				</div>
				<hr />
			
			</article> -->

			

		<?php endif; // End of posts if ?>

		<?php // Display pagination if needed
		if ( is_paged() ) : ?>
			<nav id="post-nav">
				<div class="post-previous"><?php next_posts_link( __( '&larr; Starší', 'starter' ) ); ?></div>
				<div class="post-next"><?php previous_posts_link( __( 'Novější &rarr;', 'starter' ) ); ?></div>
			</nav>
		<?php endif; ?>
		</div><!-- /.archive-posts -->

	</div>
</div><!-- /.archive-section -->

<?php get_footer(); ?>