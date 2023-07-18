<?php get_header(); ?>
<?php get_template_part('inc/project_tax_list'); ?>
<?php
global $post;

wp_reset_query();
$paged = get_query_var('paged');
query_posts( array(
						'posts_per_page' => 9,
						'post_type'   => 'mau_project',
						'paged'      => 0,
						'orderby' => 'menu_order',
    					'order'   => 'ASC',
						'post_status' => 'publish',
						'tax_query' => array(
							array(
								'taxonomy' => 'mau_project_tax',
								'field'    => 'slug',
								'terms'    => array('finished'),
								'operator' => 'NOT IN',
							),
						),
			));
?>

<div class="row projects" id="projects-container">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?> >
			<div class="inner">
				<a class="thumb-link" href="<?php the_permalink(); ?>">
					<?php
						//the_post_thumbnail('thumbnail');
						$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()  ), "medium" );
						if(!empty($thumbnail_src[0]) || is_file($thumbnail_src[0])){
						?>
						<img src="<?=$thumbnail_src[0]?>"  />
						<?php
						}else{
							the_post_thumbnail('medium');
						}
					?>
				</a>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php do_action('magiclab_project_tax_link'); ?>
				<?php do_action('magiclab_award_icon'); ?>
			</div>
		</article>
	<?php endwhile; endif; ?>
</div>
<div class="row">
	<div class="columns small-12 more-link">
		<img src="<?=get_template_directory_uri()?>/images/loader.svg" />
		<a class="magic-button load-more-work" data-call="works_more" data-tax="" data-paged="1" data-sum="9"><?php esc_html_e('View More', 'magiclab'); ?></a>
	</div>
</div>
<?php wp_reset_query(); ?>

<?php get_footer(); ?>
