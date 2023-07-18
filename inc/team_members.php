<?php
	$args = array(
		'post_type' => 'mau_team',
		'nopaging' => true,
	);
	$members = get_posts( $args );
?>
	<div class="row team">
		<?php foreach ( (array) $members as $member) : ?>
		<?php
			$role = get_field( 'team_roles', $member->ID );
			$role = $role ? $role->name : '';
			$mail  = startup_email_shortcode( '', get_field( 'team_mail', $member->ID ) );
			$phone = startup_phone_shortcode( '', get_field( 'team_phone', $member->ID ) );
		?>
			<div class="member columns medium-6 large-3">
				<h3><?php echo esc_html($member->post_title); ?></h3>
				<ul>
					<li><?php echo esc_html($role); ?></li>
					<li><?php echo $mail;  ?></li>
					<li><?php echo $phone; ?></li>
				</ul>
			</div>
		<?php endforeach; ?>
	</div>