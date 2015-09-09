<?php

  class ThemeFunctions {

    public function __construct() {
      add_action( 'after_setup_theme', array( $this, 'themeSetup' ) );
      add_action( 'wp_enqueue_scripts', array( $this, 'addThemeScriptsAndStyles' ) );
    }

    public function themeSetup() {
      // All theme initialization code goes here...

      register_nav_menus( array(
        'primary'   => __( 'Navigation Menu', 'myplay' ),
        'secondary' => __( 'Footer Nav', 'myplay' )
      ) );

      add_theme_support( 'automatic-feed-links' );
      add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
      add_theme_support( 'post-thumbnails' );
      add_image_size( 'default-thumb', 400, 400, array( 'top', 'center' ) );

    }

    public function addThemeScriptsAndStyles() {

      $mainCSSFile   = '/styles/css/main.css';
      $mainJSFile    = '/scripts/js/main.js';
      $vendorCSSFile = '/lib/libs.css';
      $vendorJSFile  = '/lib/libs.js';

      if ( ! is_admin() ) {

        // Add vendor files
        if ( file_exists( get_template_directory() . $vendorCSSFile ) ) {
          wp_enqueue_style( 'vendor-styles', get_template_directory_uri() . $vendorCSSFile );
        }

        if ( file_exists( get_template_directory() . $vendorJSFile ) ) {
          wp_enqueue_script( 'vendor-scripts', get_template_directory_uri() . $vendorJSFile, array( 'jquery' ) );
        }

        // Add main.css and main.js files
        if ( file_exists( get_template_directory() . $mainCSSFile ) ) {
          wp_enqueue_style( 'main-style', get_template_directory_uri() . $mainCSSFile );
        }

        if ( file_exists( get_template_directory() . $mainJSFile ) ) {
          wp_enqueue_script( 'main-script', get_template_directory_uri() . $mainJSFile, array(
            'jquery',
            'vendor-scripts'
          ), true );
        }

      }

      if ( defined( 'LOCAL_DEV_MODE' ) ) {
        wp_register_script( 'livereload', 'http://localhost:35729/livereload.js?snipver=1', null, false, true );
        wp_enqueue_script( 'livereload' );
      }
    }


  }

  $themeFunctions = new ThemeFunctions();
