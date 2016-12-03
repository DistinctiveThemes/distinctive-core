<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_team_feed_block', 99 );

// BLOG FEED
function distinctpress_team_feed_block() { 
  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'team_feed_layout' => array(
                  'name' => __('Team Feed', 'distinctpress'),
                  'description' => __('Display a feed of your team members.', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'team_feed_layout',
                        'label' => 'Team Feed Layout',
                        'type' => 'select',
                        'options' => array(
                             'team-grid' => 'Team Grid',
                             'team-grid-alt' => 'Team Grid (Alt Style)',
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

function team_feed_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'team_feed_layout' => 'team-grid',   
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

    $output = '';

    if ( $blog_query -> have_posts() ) :
        while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
              $output .= get_template_part( 'content/content-' . $team_feed_layout );
        endwhile; 
    endif;   
   
    return $output;
}

add_shortcode('team_feed_layout', 'team_feed_layout_shortcode'); 

?>