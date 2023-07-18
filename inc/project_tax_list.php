<?php include_once('MagicLab_Walker_Category.php'); ?>

<div class="project-tax-list row">
	<ul class="columns small-12">
		<li class="<?php echo is_post_type_archive('mau_project') ? 'active':'' ?>">
			<a href="<?php echo get_post_type_archive_link('mau_project') ?>">
				<?php _e('All'); ?>
			</a>
		</li>
		<?php
		$terms = get_terms(array(
			'taxonomy'   => 'mau_project_tax'
		));

		if(!empty($terms)){
			foreach($terms as $t){
			?>
			<li><a data-taxonomy="<?=$t->slug?>" class="works-category"><?=$t->name;?></a></li>
			<?php
			}
		}

		/*
			wp_list_categories( array(
				'taxonomy'   => 'mau_project_tax',
				'title_li'   => '',
				'show_count' => false,
				'exclude'    => 16,
				'walker'     => new MagicLab_Walker_Category()
			) );
			*/
		?>
	</ul>
</div>
