<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_team_carousel_block', 99 );

// BLOG FEED
function distinctpress_team_carousel_block() { 
  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'team_carousel_layout' => array(
                  'name' => __('Team Carousel', 'distinctpress'),
                  'description' => __('Display a feed of your team members.', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'team_carousel_layout',
                        'label' => 'Team Carousel Layout',
                        'type' => 'select',
                        'options' => array(
                             'team-grid' => 'Team Grid',
                             'team-grid-minimal' => 'Team Grid Minimal',
                        ),
                        'value' => 'team-grid',
                        'description' => 'Choose how you wish to display your team.',
                        'admin_label' => true,
                      ),
                      array(
                        'name' => 'post_filter',
                        'label' => 'Team Categories',
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

function team_carousel_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'team_carousel_layout' => 'team-grid',   
        'post_filter' => 'all'  ,
        'number_of_posts' => '6'  
    ), $atts) );

    $args = array(
        'post_type'      => 'team',
        'posts_per_page' => $number_of_posts,
    );

    $taxonomy = 'team-category';
    $tax_terms = get_terms( $taxonomy );

    $filters = array();

    foreach ( $tax_terms as $tax_term ) {
      $filters[] = $tax_term->term_id;
    }

    if (!( $post_filter == 'all' )) {
      if( function_exists( 'icl_object_id' ) ){
        $post_filter = (int)icl_object_id( $post_filter, 'team-category', true);
      }
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'team-category',
          'field' => 'id',
          'terms' => $filters
        )
      );
    }

    $blog_query = new WP_Query ( $args ); 

    ob_start(); ?>

    <div class="slick-carousel dots-inner slide entry-featured-image" data-slick='{"slidesToShow": 3 , "dots": true, "arrows": false, "adaptiveHeight": true, "autoplay": false}' data-items-1024-down="2" data-items-600-down="2" data-items-480-down="1">      

    <?php
    if ( $blog_query -> have_posts() ) :
        while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
              get_template_part( 'content/content-' . $team_carousel_layout );
        endwhile; 
    endif;   
    ?>

    </div>

    <?php

    wp_reset_postdata();

    $output = ob_get_contents();

    ob_end_clean();

    return $output;
}

add_shortcode('team_carousel_layout', 'team_carousel_layout_shortcode'); 

?>