<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_testimonials_feed_block', 99 );

// BLOG FEED
function distinctpress_testimonials_feed_block() { 
  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'testimonials_feed_layout' => array(
                  'name' => __('Testimonials Feed', 'distinctpress'),
                  'description' => __('Display a recent feed of your latest news.', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'testimonials_feed_layout',
                        'label' => 'Testimonials Feed Layout',
                        'type' => 'select',
                        'options' => array(
                             'testimonial-grid' => 'Testimonials Grid',
                             'testimonial-grid-3-col' => 'Testimonials Grid (3 Columns)',
                             'testimonial-list' => 'Testimonials List',
                        ),
                        'value' => 'post-grid',
                        'description' => 'Choose how you wish to display your news.',
                        'admin_label' => true,
                      ),
                      array(
                          'name' => 'number_of_posts',
                          'label' => 'Number of Posts to Display?',
                          'type' => 'text', 
                          'value' => '6',
                      ),
                  )
              ), 
          )
      );   
  }  
}  

function testimonials_feed_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'testimonials_feed_layout' => 'testimonial-grid',
        'number_of_posts' => '6'  
    ), $atts) );

    $args = array(
        'post_type'      => 'testimonial',
        'posts_per_page' => $number_of_posts,
    );

    $blog_query = new WP_Query ( $args );

    ob_start(); ?>

    <div class="clear-me row">

    <?php if ( $blog_query -> have_posts() ) :
        while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
               get_template_part( 'content/content-' . $testimonials_feed_layout );
        endwhile; 
    endif; ?> 

    </div> 

    <?php 

    wp_reset_postdata();

    $output = ob_get_contents();

    ob_end_clean();

    return $output;
}

add_shortcode('testimonials_feed_layout', 'testimonials_feed_layout_shortcode'); 

?>