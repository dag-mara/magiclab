<?php 

/**
 * Finished Projects Ajaxified
 *
 * Leaving this template here in case I'll come back to the AJAX based solution 
 * where loading all featured posts data wouldn't be desired
 *
 * @todo HOW TO DEAL WITH right/left DIR !! ?? 
 * IDEA 1: BY JS
 * IDEA 2: SET TWO INDEXES ONE FOR FEATURED AND ONE FOR ALL
 */

$all_args = array(
	'post_type'      => 'mau_finished_project',
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'fields'         => 'ids',
	'posts_per_page' => -1
);
$all_posts_ids = get_posts( $all_args );

$feat_args = array(
	'meta_key'       => '_mau_feat_lite',
	'fields'         => '',
	'posts_per_page' => 16,
);
$feat_posts = get_posts(wp_parse_args($feat_args, $all_args));
// $feat_count = count($feat_posts);
// $no_of_posts_to_add = $feat_args['posts_per_page'] - $feat_count;
// echo '<pre>'.print_r($feat_posts,1).'</pre>';die;
$feat_posts_by_id = array();
foreach ( $feat_posts as $feat_post )
	$feat_posts_by_id[$feat_post->ID] = $feat_post;
$feat_posts_ids = array_keys($feat_posts_by_id);

?>

<div id="finished-projects" class="row">
	<div id="info-wrapper"></div>
	<h2><?php esc_html_e('Feature Films','magiclab'); ?></h2>
		<?php 
			$i=0; 
			foreach ( $all_posts_ids as $post_id ) : 
				if ( in_array($post_id, $feat_posts_ids ) ) : // is feat
					$post = $feat_posts_by_id[$post_id];
					setup_postdata($post); 
					if ( ! has_post_thumbnail() ) 
						continue; 
					$i++;
					$dir = $i > 4 ? 'right' : 'left';
					if ( $i >= 8 ) $i = 0; 
					?>
					<div class="finished-project" data-project-id="<?php echo $post_id; ?>">
						<a href="#info"><?php the_post_thumbnail('thumbnail'); ?></a>
						<div class="finished-project-info finished-project-<?php echo $dir; ?>" data-info-id="<?php echo $post_id; ?>">
							<h3><?php the_title(); ?></h3>
							<?php the_content(); ?>
							<?php get_template_part('inc/awards'); ?>
							<?php magiclab_trailer_link($post->ID); ?>
							<span class="info-close"></span>
						</div>
					</div>
				<?php else : // is not feat ?>
					<div class="finished-project" data-project-id="<?php echo $post_id; ?>">
						<div class="finished-project-info finished-project-<?php echo $dir; ?>" data-info-id="<?php echo $post_id; ?>">
						</div>
					</div>
				<?php endif; // @endof is feat
			endforeach; 
		?>
		<?php wp_reset_query(); ?>
</div>