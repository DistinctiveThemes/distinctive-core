<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_blog_carousel_block', 99 );

// BLOG FEED
function distinctpress_blog_carousel_block() { 
  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'blog_carousel_layout' => array(
                  'name' => __('Blog Carousel', 'distinctpress'),
                  'description' => __('Display a feed of your team members.', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'blog_carousel_layout',
                        'label' => 'Blog Carousel Layout',
                        'type' => 'select',
                        'options' => array(
                             'post-grid' => 'Blog Grid',
                             'post-grid-minimal' => 'Blog Grid Minimal',
                             'post-grid-minimal-no-padding' => 'Blog Grid Minimal (No Padding)',
                        ),
                        'value' => 'blog-grid',
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

function blog_carousel_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'blog_carousel_layout' => 'post-grid',   
        'post_filter' => 'all'  ,
        'number_of_posts' => '6'  
    ), $atts) );

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $number_of_posts,
    );

    if(empty($post_filter)) {
      $post_filter = 'all';
    }

    if (!( $post_filter == 'all' )) {
      $myArray = explode(',', $post_filter);

      $filters = array();

      foreach ($myArray as $filter) {
          $filter = str_replace('post:', '', $filter);
          $idObj = get_category_by_slug($filter); 
          $id = $idObj->term_id;

          $filters[] = $id;
      }

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
      <div class="slick-carousel dots-inner slide entry-featured-image" data-slick='{"slidesToShow": 3 , "dots": false, "arrows": true, "adaptiveHeight": false, "autoplay": true}'>  

      <?php if ( $blog_query -> have_posts() ) :
          while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
                 get_template_part( 'content/content-' . $blog_carousel_layout );
          endwhile; 
      endif; ?> 

      </div> 
    </div> 

    <?php $output = ob_get_contents();

    ob_end_clean();

    return $output; 
}

add_shortcode('blog_carousel_layout', 'blog_carousel_layout_shortcode'); 

?>