<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_blog_feed_block', 99 );

// BLOG FEED
function distinctpress_blog_feed_block() { 
  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'blog_feed_layout' => array(
                  'name' => __('Blog Feed', 'distinctpress'),
                  'description' => __('Display a recent feed of your latest news.', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'blog_feed_layout',
                        'label' => 'Blog Feed Layout',
                        'type' => 'select',
                        'options' => array(
                             'post-grid' => 'Post Grid',
                             'post-grid-3-col' => 'Post Grid (3 Columns)',
                             'post-grid-minimal' => 'Post Grid Minimal',
                             'post-grid-3-col-minimal' => 'Post Grid Minimal (3 Columns)',
                             'post-list' => 'Post List',
                        ),
                        'value' => 'post-grid',
                        'description' => 'Choose how you wish to display your news.',
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

function blog_feed_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'blog_feed_layout' => 'post-grid-3-col',   
        'post_filter' => 'all'  ,
        'number_of_posts' => '6'  
    ), $atts) );

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $number_of_posts,
    );

    $myArray = explode(',', $post_filter);

    $filters = array();

    foreach ($myArray as $filter) {
        $filter = str_replace('post:', '', $filter);
        $idObj = get_category_by_slug($filter); 
        $id = $idObj->term_id;

        $filters[] = $id;
    }

    if (!( $post_filter == 'all' )) {
      if( function_exists( 'icl_object_id' ) ){
        $post_filter = (int)icl_object_id( $post_filter, 'category', true);
      }
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'category',
          'field' => 'id',
          'terms' => $filters
        )
      );
    }


    $blog_query = new WP_Query ( $args );

    ob_start(); ?>

    <div class="clear-me row">

    <?php if ( $blog_query -> have_posts() ) :
        while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
               get_template_part( 'content/content-' . $blog_feed_layout );
        endwhile; 
    endif; ?> 

    </div> 

    <?php $output = ob_get_contents();

    ob_end_clean();

    return $output;
}

add_shortcode('blog_feed_layout', 'blog_feed_layout_shortcode'); 

?>