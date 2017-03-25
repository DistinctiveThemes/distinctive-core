<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_user_submitted_blog_feed_block', 99 );

// BLOG FEED
function distinctpress_user_submitted_blog_feed_block() { 
  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'user_submitted_blog_feed_layout' => array(
                  'name' => __('User Submitted Blog Feed', 'distinctpress'),
                  'description' => __('Display a recent feed of your latest user submitions.', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'user_submitted_blog_feed_layout',
                        'label' => 'User Submited Blog Feed Layout',
                        'type' => 'select',
                        'options' => array(
                             'post-grid' => 'Post Grid',
                             'post-grid-3-col' => 'Post Grid (3 Columns)',
                             'post-grid-minimal' => 'Post Grid Minimal',
                             'post-grid-3-col-minimal' => 'Post Grid Minimal (3 Columns)',
                             'post-list' => 'Post List',
                             'post-cards-3-col' => 'Post Cards (3 Columns)',
                             'post-mini-cards' => 'Post Mini Cards (1 Column)',                             
                             'post-mini-cards-detailed' => 'Post Mini Cards + Excerpt (1 Column)',
                             'post-micro-cards' => 'Post Cards 50/50 (1 Column)',
                        ),
                        'value' => 'post-grid',
                        'description' => 'Choose how you wish to display your news.',
                        'admin_label' => true,
                      ),
                      array(
                          'name' => 'number_of_posts',
                          'label' => 'Number of Posts to Display?',
                          'type' => 'text', 
                          'value' => '9',
                      ),
                      array(
                          'name' => 'number_of_posts_offset',
                          'label' => 'Number of Posts to Offset?',
                          'type' => 'text', 
                          'value' => '0',
                      ),
                  )
              ), 
          )
      );   
  }  
}  

function user_submitted_blog_feed_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'user_submitted_blog_feed_layout' => 'post-grid-3-col', 
        'number_of_posts' => '6',
        'number_of_posts_offset' => '0'  
    ), $atts) );

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $number_of_posts,
        'offset'         => $number_of_posts_offset,
        'meta_query' => array(
            array(
                'key' => 'is_submission',
                'value' => 1,
            )
        )
    );

    $blog_query = new WP_Query ( $args );

    ob_start(); ?>

    <div class="clear-me row">

    <?php if ( $blog_query -> have_posts() ) :
        while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
               get_template_part( 'content/content-' . $user_submitted_blog_feed_layout );
        endwhile; 
    endif; ?> 

    </div> 

    <?php 

    wp_reset_postdata();

    $output = ob_get_contents();

    ob_end_clean();

    return $output;
}

add_shortcode('user_submitted_blog_feed_layout', 'user_submitted_blog_feed_layout_shortcode'); 

?>