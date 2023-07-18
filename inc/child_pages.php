<?php foreach ( (array) get_pages( 'nopaging=1&child_of='.get_the_ID()) as $post ) : setup_postdata($post); ?>
	<div class="row child-page page-<?php echo $post->post_name; ?>">
		<div class="columns small-12">
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>
		</div>
	</div>
<?php endforeach; ?>
<?php wp_reset_query(); ?>