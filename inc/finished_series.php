<?php
/**
 * Finished Series
 *
 * Template for loading finished seriess.
 *
 * Loads all at once but displays only
 * featured series on initial load.
 *
 */

$template_qvars = array(
	'heading_text' 		 => 'Series',
	'number_of_featured' => 8,
	'post_type' 		 => 'mlab_finished_series',
	'container_id' 		 => 'finished-series',
	'show_all_id' 		 => 'finished-series-show-all',
);

foreach ($template_qvars as $qv_key => $qv_val) {
	set_query_var($qv_key, $qv_val);
}

get_template_part('inc/finished_projects_base');
