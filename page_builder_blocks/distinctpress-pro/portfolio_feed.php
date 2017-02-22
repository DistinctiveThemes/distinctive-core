<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_portfolio_feed_block', 99 );

// BLOG FEED
function distinctpress_portfolio_feed_block() { 
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
                             'portfolio-lightbox-grid' => 'Portfolio Lightbox Grid (2 Columns)',
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

function portfolio_feed_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'portfolio_feed_layout' => 'portfolio-grid-3-col',   
        'category_filter' => 'all'  ,
        'number_of_posts' => '6',
        'show_filters' => 'show'  
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

    <?php
      if( $category_filter == 'all' ){
        $cats = get_categories('taxonomy=portfolio-category');
      } else {
        $cats = get_categories('taxonomy=portfolio-category&exclude='. $category_filter .'&child_of='. $filter);
      }
    ?>

    <div class="isotope-portfolio">

      <?php if($show_filters == 'show') { ?>
      <div class="portfolio-filter">
        <ul>
            <li id="filter--all" class="filter active" data-filter="*"><?php _e( 'View All', 'distinctpress' ); ?></li>
            <?php foreach ($cats as $cat ) : ?>
                <li class="filter" data-filter=".<?php echo esc_attr($cat->slug); ?>"><?php echo esc_attr($cat->name); ?></li>
            <?php endforeach; ?>
        </ul>
      </div>
      <?php } ?>

      <div class="portfolio-items">
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

    wp_reset_postdata();
}

add_shortcode('portfolio_feed_layout', 'portfolio_feed_layout_shortcode'); 

?>