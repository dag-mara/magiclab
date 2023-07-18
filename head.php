<?php

header("Link: </wp-content/themes/magiclab-theme/style.css>; rel=preload; as=style", false);
header("Link: </wp-content/themes/startup5/css/startup.css>; rel=preload; as=style", false);
header("Link: </wp-content/themes/startup5/foundation/css/foundation.min.css>; rel=preload; as=style", false);

//header("Link: </wp-includes/css/dist/block-library/style.min.css>; rel=preload; as=style", false);
header("Link: </wp-content/plugins/contact-form-7/includes/css/styles.css>; rel=preload; as=style", false);


header("Link: </wp-content/themes/magiclab-theme/fonts/EuclidFlex-Light-WebS.woff>; rel=preload; as=font; type=font/woff", false);
header("Link: </wp-content/themes/magiclab-theme/fonts/EuclidFlex-Medium-WebS.woff>; rel=preload; as=font; type=font/woff", false);

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />

	<title><?php wp_title(); ?></title>
	<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/foundation/css/foundation.min.css">
	<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/css/startup.css">
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>">
	<link rel="preconnect" href="https://i.vimeocdn.com">
	<link rel="dns-prefetch" href="https://i.vimeocdn.com">
	<link rel="preconnect" href="https://www.google-analytics.com">
	<link rel="dns-prefetch" href="https://www.google-analytics.com">
	<link rel="preconnect" href="https://maps.googleapis.com">
	<link rel="dns-prefetch" href="https://maps.googleapis.com">

	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon2.png">
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
