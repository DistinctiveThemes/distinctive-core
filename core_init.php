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

?>