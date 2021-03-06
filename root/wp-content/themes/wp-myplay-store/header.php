<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml">
<!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>"/>
  <meta name="viewport" content="width=device-width, user-scalable=no"/>
  <meta name="description" content="<?php bloginfo( 'description' ); ?>"/>
  <meta name="keywords" content="<?php bloginfo( 'name' ); ?>"/>
  <meta property="og:type" content="website"/>
  <meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>"/>
  <meta property="fb:app_id" content="270065846467161"/>

  <title><?php echo _rgnrtrWPTitle(); ?></title>

  <?php if ( is_single() ) : global $post;
    setup_postdata( $post ); ?>
    <meta property="og:title" content="<?php the_title(); ?>"/>
    <meta property="og:url" content="<?php the_permalink( $post->ID ); ?>"/>
    <meta property="og:image" content=""/>
    <meta property="og:description" content=""/>

  <?php else : ?>
    <meta property="og:title" content="<?php bloginfo( 'name' ); ?>"/>
    <meta property="og:url" content="<?php bloginfo( 'url' ); ?>"/>
    <meta property="og:image" content=""/>
    <meta property="og:description" content="<?php echo bloginfo( 'description' ); ?>"/>
  <?php endif; ?>

  <?php if ( file_exists( bloginfo( 'template_directory' ) . '/images/favicon.ico' ) ) : ?>
    <link rel="shortcut icon" href="<?php bloginfo( 'template_directory' ); ?>/images/favicon.ico" type="image/x-icon"/>
  <?php endif; ?>
  <link rel="profile" href="http://gmpg.org/xfn/11"/>
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="site-container" class="site-container">

  <div id="header-container" class="header-container">
    <?php get_header( 'main' ); ?>
  </div>

  <main id="main-container" class="main-container" role="main">
