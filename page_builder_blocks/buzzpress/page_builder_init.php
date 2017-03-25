<?php

/* LOAD OUR CUSTOM BLOCKS */
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/buzzpress/blog_feed.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/buzzpress/blog_feed_reactions.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/buzzpress/blog_carousel.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/buzzpress/blog_slider.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/buzzpress/contact_form_7.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/buzzpress/comments.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/buzzpress/hero_slider.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/buzzpress/media_grid.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/buzzpress/simple_button.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/buzzpress/revslider.php' );

if ( !function_exists('is_plugin_active') ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if (is_plugin_active( 'user-submitted-posts/user-submitted-posts.php' )) {
	require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/buzzpress/user_submitted_blog_feed.php' );
}

?>