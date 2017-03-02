<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_testimonials_carousel_block', 99 );

// BLOG FEED
function distinctpress_testimonials_carousel_block() { 
  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'testimonials_carousel_layout' => array(
                  'name' => __('Testimonials Carousel', 'distinctpress'),
                  'description' => __('Display a feed of your team members.', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'testimonials_carousel_layout',
                        'label' => 'Testimonials Carousel Layout',
                        'type' => 'select',
                        'options' => array(
                             'testimonial-grid' => 'Testimonials Grid',
                             'testimonial-grid-3-col' => 'Testimonials Grid (3 Columns)',
                             'testimonial-list' => 'Testimonials List',
                        ),
                        'value' => 'team-grid',
                        'description' => 'Choose how you wish to display your team.',
                        'admin_label' => true,
                      ),
                      array(
                          'name' => 'number_of_columns',
                          'label' => 'Number of Columns to Display?',
                          'type' => 'text', 
                          'value' => '3',
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

function testimonials_carousel_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'testimonials_carousel_layout' => 'testimonial-grid',   
        'post_filter' => 'all'  ,
        'number_of_posts' => '6',
        'number_of_columns' => '3'  
    ), $atts) );

    $args = array(
        'post_type'      => 'testimonial',
        'posts_per_page' => $number_of_posts,
    );

    $blog_query = new WP_Query ( $args ); ?>

    <div class="slick-carousel dots-inner slide entry-featured-image" data-slick='{"slidesToShow": <?php echo esc_attr($number_of_columns); ?> , "dots": true, "arrows": false, "adaptiveHeight": true, "autoplay": false}' data-items-1024-down="2" data-items-600-down="2" data-items-480-down="1">      

    <?php
    if ( $blog_query -> have_posts() ) :
        while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
              get_template_part( 'content/content-' . $testimonials_carousel_layout );
        endwhile; 
    endif;   
    ?>

    </div>

    <?php

    wp_reset_postdata();
}

add_shortcode('testimonials_carousel_layout', 'testimonials_carousel_layout_shortcode'); 

?>