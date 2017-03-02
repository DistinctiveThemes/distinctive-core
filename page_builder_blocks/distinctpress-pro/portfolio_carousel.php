<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_portfolio_carousel_block', 99 );

// BLOG FEED
function distinctpress_portfolio_carousel_block() { 
  if (function_exists('kc_add_map')) { 

      $args = array(
        'orderby'                  => 'name',
        'hide_empty'               => 0,
        'hierarchical'             => 1,
        'taxonomy'                 => 'portfolio-category'
      );
      $cats = get_categories( $args );
      $final_cats = array( 'all' => 'Show all categories' );      
      foreach( $cats as $cat ){
        $final_cats[$cat->term_id] = $cat->name;
      }
      
      kc_add_map(
          array( 
              'portfolio_carousel_layout' => array(
                  'name' => __('Portfolio Carousel', 'distinctpress'),
                  'description' => __('Display a feed of your projects.', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'portfolio_carousel_layout',
                        'label' => 'Portfolio Carousel Layout',
                        'type' => 'select',
                        'options' => array(
                             'portfolio-grid' => 'Portfolio Grid',
                             'portfolio-lightbox-grid' => 'Portfolio Grid Lightbox',
                        ),
                        'value' => 'portfolio-grid',
                        'description' => 'Choose how you wish to display your projects.',
                        'admin_label' => true,
                      ),
                      array(
                          'name' => 'category_filter',
                          'label' => 'Which Categories To Display?',
                          'type' => 'select', 
                          'options' => $final_cats,
                          'value' => 'all', 
                          'description' => 'Choose a category to display',
                      ),
                      array(
                          'name' => 'number_of_posts',
                          'label' => 'Number of Posts to Display?',
                          'type' => 'text', 
                          'value' => '9',
                      ),
                  )
              ), 
          )
      );   
  }  
}  

function portfolio_carousel_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'portfolio_carousel_layout' => 'portfolio-grid',   
        'category_filter' => 'all'  ,
        'number_of_posts' => '6'  
    ), $atts) );

    $args = array(
        'post_type'      => 'portfolio',
        'posts_per_page' => $number_of_posts,
    );

    if (!( $category_filter == 'all' )) {
      if( function_exists( 'icl_object_id' ) ){
        $category_filter = (int)icl_object_id( $category_filter, 'portfolio-category', true);
      }
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'portfolio-category',
          'field' => 'id',
          'terms' => $category_filter
        )
      );
    }

    $blog_query = new WP_Query ( $args ); ?>

    <div class="slick-carousel dots-inner slide drag-icon" data-slick='{"slidesToShow": 3 , "dots": false, "arrows": true, "adaptiveHeight": true, "autoplay": false}'>      

    <?php
    if ( $blog_query -> have_posts() ) :
        while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
              get_template_part( 'content/content-' . $portfolio_carousel_layout );
        endwhile; 
    endif;   
    ?>

    </div>

    <?php wp_reset_postdata();
}

add_shortcode('portfolio_carousel_layout', 'portfolio_carousel_layout_shortcode'); 

?>