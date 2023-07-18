<?php if ( function_exists('have_rows') ) : ?>

	<?php
		// if there is a master project get it's awards instead
		$post_id = get_the_ID();
		if ( $master_id = magiclab_get_master_project_id($post_id) ) {
			$post_id = $master_id;
		}
	?>

	<?php if( have_rows('ml_project_awards_v2',$post_id) ) : ?>

		<?php $rows_count = count( get_field('ml_project_awards_v2',$post_id) ); $i=0; ?>
		
		<ul class="project-awards project-awards-v2 row">
			<?php while ( have_rows('ml_project_awards_v2',$post_id) ) : the_row(); $i++; ?>
				<li class="columns small-6 <?php echo $i == $rows_count ? 'end':''; ?>">
					<div>
					<?php 
						$award_rows = get_sub_field('ml_project_award_rows'); 
						if ( is_array($award_rows) && ! empty($award_rows) ) {
						 foreach ( $award_rows as $award_row ) {
							 if ( empty($award_row['ml_project_award_text']) ) 
							 	continue;
							 $classes = 'award-text';
							 if ( 'bold' == $award_row['ml_project_award_weight'] ) 
							 	$classes .= ' award-weight-bold';
							 if ( 'large' == $award_row['ml_project_award_size'] ) 
							 	$classes .= ' award-size-large';
							 echo '<span class="'.esc_attr($classes).'">'.wp_strip_all_tags($award_row['ml_project_award_text']).'</span>';
						  }
						}
					?>
				</div>
				</li>
		    <?php endwhile; ?>
		</ul>

	<?php endif; // @endof if have rows ?>

<?php endif; // @endof if function_exists ?>