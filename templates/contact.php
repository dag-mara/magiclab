<?php
/*
Template Name: Contact Page
*/
?>

<?php get_header(); ?>

<div class="row">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?> >

			<div class="inner row">

				<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>

				<div class="entry column medium-4">
					<?php the_content(); ?>
				</div>

				<div class="secondary column medium-8">
					<?php get_template_part('inc/google_map'); ?>
					<?php get_template_part('inc/team_members'); ?>
				</div>

			</div>

		</article>

	<?php endwhile; endif;?>
</div>

<?php get_footer(); ?>