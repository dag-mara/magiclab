<?php get_header(); ?>
<!-- <div class="jobs-menu">
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
</div> -->

        <div id="<?php the_sub_field('anchor');?>" class="row projects-container jobs single">
            <article class="type-mau_project">
                <div class="columns image">
                    <?php echo the_post_thumbnail('large')?>
                </div>
                <div class="entry column">
                    <h1 class="text-center"><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
                <div class="application column">
                    <h2 class="text-center showform">Apply for this job</h2>
                    <?php gravity_form( 1, false, false, false, '', false ); ?>
                </div>
                
            </article>
            
        </div>



<?php get_footer(); ?>