<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, user-scalable=no" />
<title>
	<?php echo _rgnrtrWPTitle(); ?>
</title>
<meta name="description" content="<?php bloginfo( 'description' ); ?>" />
<meta name="keywords" content="<?php bloginfo( 'name' ); ?>" />
<?php if(is_single()) : global $post; setup_postdata($post); ?>
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:url" content="<?php the_permalink( $post-ID ); ?>" />
	<meta property="og:image" content="<?php echo _rgnrtrGetImageURL( $post-ID ); ?>" />
	<meta property="og:description" content="<?php echo _rgnrtrExcerpt(20, false, '', true); ?> " />
<?php else : ?>
	<meta property="og:title" content="<?php bloginfo( 'name' ); ?>" />
	<meta property="og:url" content="<?php bloginfo( 'url' ); ?>" />
	<meta property="og:image" content="<?php echo _rgnrtrGetImageURL( $post-ID ); ?>" />
	<meta property="og:description" content="<?php echo bloginfo('description'); ?>" />
<?php endif; ?>
<meta property="og:type" content="website" />
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
<meta property="fb:app_id" content="270065846467161" />
<link rel="shortcut icon" href="<?php bloginfo( 'template_directory' ); ?>/images/favicon.ico" type="image/x-icon" />	
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script><![endif]-->
<?php wp_head(); ?>
</head>

<body <?php _rgnrtrIOSClass( body_class() ); ?> >
<div id="master-container">

	<div id="header-block" class="block">
		<div class="container clearfix">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="logo hidetext"><?php bloginfo( 'name' ); ?></a>
			<a href="#" class="mobile_nav closed"></a>
			<div class="main-nav nav-container">
			   <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			</div>
		</div>
	</div><!-- #header-block -->
		
	<div id="main-content" class="block">
		<div class="container clearfix">
