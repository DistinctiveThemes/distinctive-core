<?php

/*
Plugin Name: Distinctive Core
Plugin URI: http://www.distinctivethemes.com
Description: Core Framework Plugin for Distinctive Themes WordPress Themes.
Version: 1.0
Author: Distinctive Themes
Author URI: http://www.distinctivethemes.com
*/	
/**
 * Plugin definitions
 */
define( 'DISTINCTIVE_CORE_PATH', trailingslashit(plugin_dir_path(__FILE__)) );
define( 'DISTINCTIVE_CORE_VERSION', '1.0');

/**
 * Grab all custom post type functions
 */
require_once( DISTINCTIVE_CORE_PATH . 'core_cpts.php' );

/**
 * Everything else in the framework is conditionally loaded depending on theme options.
 * Let's include all of that now.
 */
require_once( DISTINCTIVE_CORE_PATH . 'core_init.php' );
require_once( DISTINCTIVE_CORE_PATH . 'kirki/kirki.php' );
?>
