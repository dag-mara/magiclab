<?php
/*
Template Name: Contact Page - new
*/
?>

<?php get_header(); ?>
<div class="jobs-menu">
    <?php // Contact navigation

    
    add_action('startup_nav_bar_jobs','startup_nav_bar_jobs');
    function startup_nav_bar_contact(){

        if ( ! has_nav_menu( 'contact-menu' ) )
            return false;

        wp_nav_menu( array(
            'theme_location'  => 'contact-menu',
            'container'       => 'nav',
            'menu_class'      => 'nav-bar',
        ) );

    };
    
    startup_nav_bar_contact();?>
</div>

<div class="contact">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?> >

			<div class="inner row">

				<h1 class="text-center"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>

				<div class="entry column medium-6">
					<?php the_post_thumbnail(); ?>
				</div>

				<div class="secondary column medium-6">
               
                <?php /* get_template_part('inc/google_map');  */?>
                     <?php the_content(); ?>

					<?php //get_template_part('inc/team_members'); ?>
                    <?php if( have_rows('contact') ): ?>
                        <h2 class="contact-team-header">OUR TEAM</h2>
                        <div class="contact-cards row">
                           
                        <?php while( have_rows('contact') ): the_row();
                            ?>
                    
                            <div class="card small-6 column">
                                <?php if (get_sub_field('image')) :  ?>
                                <img class="team-img" src="<?php the_sub_field('image');?>" alt="<?php the_sub_field('name');?>">
                                <?php endif; ?>
                                <h3><?php the_sub_field('name'); ?></h3>
                                <?php the_sub_field('contacts'); ?>
                            </div>
                            <?php endwhile; ?>
                        </div>
                        <?php endif; ?>
                    </div>
             
				</div>

			</div>

		</article>

	<?php endwhile; endif;?>
</div>


<?php get_footer(); ?>