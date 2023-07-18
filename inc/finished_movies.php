<?php
/**
 * Finished Movies
 *
 * Template for loading finished movies.
 *
 * Loads all at once but displays only
 * featured movies on initial load.
 *
 */

$template_qvars = array(
	'heading_text' 		 => 'Feature Films',
	'number_of_featured' => 24,
	'post_type' 		 => 'mau_finished_project',
	'container_id' 		 => 'finished-projects',
	'show_all_id' 		 => 'finished-projects-show-all',
);

foreach ($template_qvars as $qv_key => $qv_val) {
	set_query_var($qv_key, $qv_val);
}
get_template_part('inc/finished_projects_base');
