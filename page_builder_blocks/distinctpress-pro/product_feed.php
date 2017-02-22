<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_product_feed_block', 99 );

// BLOG FEED
function distinctpress_product_feed_block() { 
  if (function_exists('kc_add_map')) { 
      $args = array(
        'orderby'                  => 'name',
        'hide_empty'               => 0,
        'hierarchical'             => 1,
        'taxonomy'                 => 'product_cat'
      );
      $cats = get_categories( $args );
      $final_cats = array( 'all' => 'Show all categories' );      
      foreach( $cats as $cat ){
        $final_cats[$cat->term_id] = $cat->name;
      }

      kc_add_map(
          array( 
              'product_feed_layout' => array(
                  'name' => __('Product Feed', 'distinctpress'),
                  'description' => __('Display a recent feed of your shop items.', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'product_feed_layout',
                        'label' => 'Product Feed Layout',
                        'type' => 'select',
                        'options' => array(
                             'product-grid' => 'Product Grid',
                             'product-grid-3-col' => 'Product Grid (3 Columns)',
                             'product-grid-minimal' => 'Product Grid Minimal',
                             'product-grid-3-col-minimal' => 'Product Grid Minimal (3 Columns)',
                        ),
                        'value' => 'product-grid',
                        'description' => 'Choose how you wish to display your news.',
                        'admin_label' => true,
                      ),
                      array(
                          'name' => 'post_filter',
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

function product_feed_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'product_feed_layout' => 'product-grid-3-col',   
        'post_filter' => 'all'  ,
        'number_of_posts' => '6'  
    ), $atts) );

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $number_of_posts,
    );

    if (!( $post_filter == 'all' )) {
      if( function_exists( 'icl_object_id' ) ){
        $post_filter = (int)icl_object_id( $post_filter, 'product_cat', true);
      }
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'product_cat',
          'field' => 'id',
          'terms' => $post_filter
        )
      );
    }


    $blog_query = new WP_Query ( $args );

    ob_start(); ?>

    <div class="clear-me row">

    <?php if ( $blog_query -> have_posts() ) :
        while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
               get_template_part( 'content/content-' . $product_feed_layout );
        endwhile; 
    endif; ?> 

    </div> 

    <?php $output = ob_get_contents();

    ob_end_clean();

    return $output;
}

add_shortcode('product_feed_layout', 'product_feed_layout_shortcode'); 

?>