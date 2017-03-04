<?php

/**
 * Grab our framework options as registered by the theme.
 * If ebor_framework_options isn't set then we'll pull a list of defaults.
 * By default everything is turned off.
 */

$defaults = array(
	'portfolio_post_type'   => '0',
	'team_post_type'        => '0',
	'client_post_type'      => '0',
	'testimonial_post_type' => '0',
	'distinctpress_blocks'     => '0'
);
$framework_options = wp_parse_args( get_option('distinctive_core_options'), $defaults);

if( '1' == $framework_options['distinctpress_blocks'] ){
	require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/distinctpress-pro/page_builder_init.php' );	
}

/**
 * Register Portfolio Post Type
 */

if( '1' == $framework_options['portfolio_post_type'] ){
		add_action( 'init', 'register_portfolio' );		
		add_action( 'init', 'create_portfolio_taxonomies');
}

/**
 * Register Team Post Type
 */
if( '1' == $framework_options['team_post_type'] ){
		add_action( 'init', 'register_team');
		add_action( 'init', 'create_team_taxonomies');
}

/**
 * Register Client Post Type
 */
if( '1' == $framework_options['client_post_type'] ){
		add_action( 'init', 'register_client' );
		add_action( 'init', 'create_client_taxonomies');
}

/**
 * Register Testimonials Post Type
 */
if( '1' == $framework_options['testimonial_post_type'] ){
		add_action( 'init', 'register_testimonials_post_type' );
		add_action( 'init', 'create_testimonial_taxonomies');
}

require_once( DISTINCTIVE_CORE_PATH . 'demo-import/one-click-demo-import.php' );	

/* 
MCE Buttons 
*/
add_action( 'init', 'distinctivecore_shortcode_button' );
function distinctivecore_shortcode_button() {
    add_filter("mce_external_plugins", "distinctivecore_shortcode_add_buttons");
    add_filter('mce_buttons', 'distinctivecore_shortcode_register_buttons');
}

function distinctivecore_shortcode_add_buttons($plugin_array) {
    $plugin_array['distinctivecore_shortcode'] = plugins_url( '/assets/js/shortcode-mce', __FILE__ );
    return $plugin_array;
}

function distinctivecore_shortcode_register_buttons($buttons) {
    array_push( $buttons, 'showrecent' ); // dropcap', 'recentposts
    return $buttons;
}

?>