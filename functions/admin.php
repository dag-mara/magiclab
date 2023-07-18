<?php

// Remove comments from admin bar
add_action( 'admin_bar_menu', 'magiclab_remove_comments_adminbar', 99 );
function magiclab_remove_comments_adminbar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node('comments');
}

// Remove items from admin menu
add_action( 'admin_menu', 'magiclab_remove_admin_menu_items', 999 );
function magiclab_remove_admin_menu_items(){
	remove_menu_page( 'edit-comments.php' );
	if ( ! current_user_can( 'update_core' ) ) {
		remove_menu_page( 'tools.php' );
		remove_submenu_page('themes.php','themes.php');
		remove_submenu_page('themes.php','customize.php');
	}
}

// Add formats dropdown menu to mce
// add_filter( 'mce_buttons', 'magiclab_style_select' );
// @unused
function magiclab_style_select( $buttons ) {
	array_push( $buttons, 'styleselect' );
	return $buttons;
}

// Add new styles to the TinyMCE "formats" menu dropdown
// add_filter( 'tiny_mce_before_init', 'magiclab_styles_dropdown' );
// @unused
function magiclab_styles_dropdown( $settings ) {
	$new_styles = array(
		array(
			'title'	=> 'Magic Lab',
			'items'	=> array(
				array(
					'title'		=> __('Lead Paragraph','magiclab'),
					'selector'	=> 'p',
					'classes'	=> 'magic-lead'
				),
				array(
					'title'		=> __('Small Paragraph','magiclab'),
					'inline'	=> 'p',
					'classes'	=> 'magic-small',
				),
			),
		),
	);
	$settings['style_formats_merge'] = true;
	$settings['style_formats'] = json_encode( $new_styles );
	return $settings;
}

// Remove Kitchen Sink Dev Template
add_filter('theme_page_templates','magiclab_page_templates');
function magiclab_page_templates($templates) {
	unset($templates['templates/list-children.php']);
	unset($templates['templates/foundation-kitchen-sink.php']);
	return $templates;
}

// Advanced Custom Fields Admin Styles
add_action('acf/input/admin_head', 'my_acf_admin_head');
function my_acf_admin_head() {
	?>
	<style type="text/css">
		.acf-button.blue[disabled], .acf-button.blue.disabled {
			display: none;
		}
	</style>
	<?php
}
