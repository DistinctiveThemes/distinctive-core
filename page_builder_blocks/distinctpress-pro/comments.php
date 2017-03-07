<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_comments_block', 99 );

// BLOG FEED
function distinctpress_comments_block() { 

  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'comments_layout' => array(
                  'name' => __('Comments', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'comments_layout',
                        'label' => 'Comments',
                        'type' => 'select',
                        'description' => 'Use this on single posts or pages to add the WordPress comments area.',
                        'admin_label' => true,
                      ),
                  )
              ), 
          )
      );   
  }  
}  

function comments_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        
    ), $atts) );

    $output = '<div class="col-sm-12">';

      $output .= comments_template( '', true );

    $output .= '</div>';

    return $output;
}

add_shortcode('comments_layout', 'comments_layout_shortcode'); 

?>