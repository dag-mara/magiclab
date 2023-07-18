<?php
global $post;
$featured = get_posts( array(
	'numberposts' => 6,
	'post_type'   => 'mau_project',
	'tax_query' => array(
		array(
			'taxonomy' => 'mau_project_tax',
			'field'    => 'slug',
			'terms'    => array('finished'),
			'operator' => 'NOT IN',
		),
	),
) );
?>
	<div class="row projects featured">
		<?php foreach( $featured as $post ) : setup_postdata( $post ); ?>

				<article class="columns medium-4" >

					<div class="inner">

						<a class="thumb-link" href="<?php the_permalink(); ?>">
							<?php
								//the_post_thumbnail('thumbnail');
								$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()  ), "medium" );
								if(!empty($thumbnail_src[0]) || is_file($thumbnail_src[0])){
								?>
								<img src="<?=$thumbnail_src[0]?>" data-src="/wp-content/themes/magiclab-theme/images/loader2.svg" class="" />
								<?php
								}else{
									the_post_thumbnail('thumb');
								}
							?>

						</a>

						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

						<?php do_action('magiclab_project_tax_link'); ?>

						<?php do_action('magiclab_award_icon'); ?>

					</div>

				</article>

		<?php endforeach; ?>
		<div class="columns small-12 more-link">
			<a class="magic-button" href="<?php echo get_post_type_archive_link('mau_project'); ?>"><?php esc_html_e('View More', 'magiclab'); ?></a>
		</div>
	</div>

<?php wp_reset_query(); ?>
