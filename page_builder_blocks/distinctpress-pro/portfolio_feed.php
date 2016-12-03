<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_portfolio_feed_block', 99 );

// BLOG FEED
function distinctpress_portfolio_feed_block() { 
  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'portfolio_feed_layout' => array(
                  'name' => __('Portfolio Feed', 'distinctpress'),
                  'description' => __('Display a recent feed of your latest news.', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'portfolio_feed_layout',
                        'label' => 'Portfolio Feed Layout',
                        'type' => 'select',
                        'options' => array(
                             'portfolio-grid' => 'Portfolio Grid (2 Columns)',
                             'portfolio-grid-3-col' => 'Portfolio Grid (3 Columns)',
                             'portfolio-grid-4-col' => 'Portfolio Grid (4 Columns)',
                             'portfolio-lightbox-grid' => 'Portfolio Grid Lightbox (2 Columns)',
                             'portfolio-lightbox-grid-3-col' => 'Portfolio Lightbox Grid (3 Columns)',
                             'portfolio-lightbox-grid-4-col' => 'Portfolio Lightbox Grid (4 Columns)',
                        ),
                        'value' => 'portfolio-grid-3-col',
                        'description' => 'Choose how you wish to display your news.',
                        'admin_label' => true,
                      ),
                      array(
                        'name' => 'show_filters',
                        'label' => 'Show Filters?',
                        'type' => 'select',
                        'options' => array(
                             'show' => 'Show Filters',
                             'hide' => 'Hide Filters',
                        ),
                        'value' => 'show',
                        'admin_label' => true,
                      ),
                      array(
                        'name' => 'post_filter',
                        'label' => 'Post Categories',
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

function portfolio_feed_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'portfolio_feed_layout' => 'portfolio-grid-3-col',   
        'post_filter' => 'all'  ,
        'number_of_posts' => '6',
        'show_filters' => 'show'  
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

    <div class="isotope-portfolio">

      <?php if($show_filters == 'show') { ?>
      <div class="portfolio-filter">
        <ul>
          <li id="filter--all" class="filter active" data-filter="*"><?php _e( 'View All', 'distinctpress' ); ?></li>
          <?php 
            $taxonomy = 'jetpack-portfolio-type';
            $tax_terms = get_terms( $taxonomy ); 
            foreach ( $tax_terms as $tax_term ) { ?>
              <li class="filter" data-filter=".<?php echo $tax_term->slug; ?>"><?php echo $tax_term->slug; ?></li>
            <?php 
            } 
            wp_reset_postdata(); ?>
        </ul>
      </div>
      <?php } ?>

      <div class="portfolio row">
      <?php 
      if ( $blog_query -> have_posts() ) :        
          while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
              get_template_part( 'content/content-' . $portfolio_feed_layout );
          endwhile;         
      endif;  
      ?>      
      </div>

    </div>
    <?php
}

add_shortcode('portfolio_feed_layout', 'portfolio_feed_layout_shortcode'); 

?>