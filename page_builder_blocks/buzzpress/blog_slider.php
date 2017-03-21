<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_blog_slider_block', 99 );

// BLOG FEED
function distinctpress_blog_slider_block() { 
  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'blog_slider_layout' => array(
                  'name' => __('Blog Slider', 'distinctpress'),
                  'description' => __('Display a feed of your posts members.', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'blog_slider_layout',
                        'label' => 'Blog Carousel Layout',
                        'type' => 'select',
                        'options' => array(
                             'post-slider-minimal' => 'Blog Slider Minimal',
                             'post-slider-detailed' => 'Blog Slider Detailed',
                             'post-slider-large' => 'Blog Slider Large',
                        ),
                        'value' => 'post-slider-minimal',
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

function blog_slider_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'blog_slider_layout' => 'post-slider-minimal',   
        'post_filter' => 'all'  ,
        'number_of_posts' => '6'  
    ), $atts) );

    if ($blog_slider_layout == 'post-slider-large') {
        $number_of_posts = '6';
    }

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

    <?php if($blog_slider_layout == 'post-slider-large') { ?> 

    <div id="large-post-slider-wrapper" class="clear-me">
      <div class="slick-carousel dots-inner slide entry-featured-image large-post-slider" data-items-1024-down="1" data-items-600-down="1" data-items-480-down="1" data-slick='{"slidesToShow": 1 , "dots": false, "arrows": true, "adaptiveHeight": true, "autoplay": true }' data-as-nav-for=".large-post-slider-nav">  

      <?php if ( $blog_query -> have_posts() ) :
          while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
                 get_template_part( 'content/content-' . $blog_slider_layout );
          endwhile; 
      endif; ?> 

      </div> 

      <div class="slick-carousel dots-inner slide entry-featured-image large-post-slider-nav" data-items-1024-down="4" data-items-600-down="2" data-items-480-down="1" data-slick='{"slidesToShow": 3 , "dots": false, "arrows": false, "adaptiveHeight": false, "autoplay": true }' data-as-nav-for=".large-post-slider">  

      <?php if ( $blog_query -> have_posts() ) :
          while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
                 get_template_part( 'content/content-post-slider-large-index' );
          endwhile; 
      endif; ?> 

      </div> 

    </div> 

    <?php } else { ?>

    <div class="clear-me">
      <div class="slick-carousel dots-inner slide entry-featured-image" data-items-1024-down="1" data-items-600-down="1" data-items-480-down="1" data-slick='{"slidesToShow": 1 , "dots": true, "arrows": false, "adaptiveHeight": false, "autoplay": true}'>  

      <?php if ( $blog_query -> have_posts() ) :
          while ( $blog_query -> have_posts() ) : $blog_query -> the_post();
                 get_template_part( 'content/content-' . $blog_slider_layout );
          endwhile; 
      endif; ?> 

      </div> 
    </div> 

    <?php } ?>

    <?php 

    wp_reset_postdata();

    $output = ob_get_contents();

    ob_end_clean();

    return $output; 
}

add_shortcode('blog_slider_layout', 'blog_slider_layout_shortcode'); 

?>