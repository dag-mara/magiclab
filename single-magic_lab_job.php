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

        <div id="<?php the_sub_field('anchor');?>" class="row projects-container jobs">
            <article class="type-mau_project">
                <div class="columns medium-7 medium-push-5 large-8 large-push-4 image">
                    <?php echo the_post_thumbnail('large')?>
                </div>
                <div class="entry column medium-5 medium-pull-7 large-4 large-pull-8">
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
                
            </article>
            
        </div>



<?php get_footer(); ?>