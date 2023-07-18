<?php get_template_part( 'head' ); ?>

<body <?php body_class(); ?> >

	<div class="site-wrapper">

		<header class="row" >
			<div class="large-12 columns" id="header" >
				<?php //do_action('startup_header_logo'); ?>
				<?php //do_action('startup_header_title'); ?>
			</div>
		</header>


		<?php do_action('startup_feat_slider'); ?>

		<div class="row nav-row">
			<div class="medium-12 columns" id="access" role="navigation" >
				<div <?php if ( ! is_front_page() ) echo 'class="sticky"'; ?>>
					<?php do_action('startup_top_bar'); ?>
				</div>
			</div>
		</div>
