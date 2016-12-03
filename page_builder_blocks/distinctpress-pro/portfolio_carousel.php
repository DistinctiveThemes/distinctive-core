<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_portfolio_carousel_block', 99 );

// BLOG FEED
function distinctpress_portfolio_carousel_block() { 
  if (function_exists('kc_add_map')) { 
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
                        'name' => 'post_filter',
                        'label' => 'Portfolio Categories',
                        'type' => 'post_taxonomy',
                        'description' => '',
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
        'post_filter' => 'all'  ,
        'number_of_posts' => '6'  
    ), $atts) );

    $args = array(
        'post_type'      => 'jetpack-portfolio',
        'posts_per_page' => $number_of_posts,
    );

    $taxonomy = 'jetpack-portfolio-type';
    $tax_terms = get_terms( $taxonomy );

    $filters = array();

    foreach ( $tax_terms as $tax_term ) {
      $filters[] = $tax_term->term_id;
    }

    if (!( $post_filter == 'all' )) {
      if( function_exists( 'icl_object_id' ) ){
        $post_filter = (int)icl_object_id( $post_filter, 'category', true);
      }
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'jetpack-portfolio-type',
          'field' => 'id',
          'terms' => $filters
        )
      );
    }

    $blog_query = new WP_Query ( $args ); ?>

    <div class="slick-carousel dots-inner slide entry-featured-image" data-slick='{"slidesToShow": 3 , "dots": true, "arrows": false, "adaptiveHeight": true, "autoplay": false}'>      

    <?php
    if ( $blog_query -> have_posts() ) :
        while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
              get_template_part( 'content/content-' . $portfolio_carousel_layout );
        endwhile; 
    endif;   
    ?>

    </div>

    <?php
}

add_shortcode('portfolio_carousel_layout', 'portfolio_carousel_layout_shortcode'); 

?>