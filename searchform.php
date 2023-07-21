<form role="search" class="searchform" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
	<div class="flex search-header">
		<img width="140" height="25" title="" alt="logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/magic-logo.svg" />
		<img width="20" height="20" class="close-searchform" title="" alt="close" src="<?php echo get_stylesheet_directory_uri(); ?>/images/magic-close.svg" />
	</div>
	<div class="flex row search-inside">
		<div class="large-8 small-9 cell">
			<input type="search" value="" name="s" id="s" placeholder="<?php esc_attr_e('Find work by client, type, year', 'magiclab'); ?>">
		</div>
		<div class="large-4 small-3 cell text-right">
			<input type="submit" id="searchsubmit" value="<?php esc_attr_e('SEARCH', 'magiclab'); ?>">
		</div>
	</div>
	<div class="flex row filter">
		<input type="checkbox" name="only_finished_projects" id="finished-only">
		<label for="finished-only">Show only finished projects</label>
	</div>
</form>