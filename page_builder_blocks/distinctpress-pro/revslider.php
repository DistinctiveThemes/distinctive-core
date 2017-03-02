<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_revslider_block', 99 );

// BLOG FEED
function distinctpress_revslider_block() { 
  global $post;
  $post_type = 'wpcf7_contact_form';

  $args = array (
      'post_type' => $post_type,
      'posts_per_page' => -1,
      'orderby' => 'menu_order',
      'order' => 'ASC',
  );

  $posts = get_posts($args);

  $form_array = array();

  foreach( $posts as $post ) { 
    setup_postdata($post);
    $form_array[$post->ID] = htmlspecialchars($post->post_title);
  }

  if ( class_exists( 'RevSlider' ) ) {
      $rev_slider = new RevSlider();
      $sliders = $rev_slider->getAllSliderAliases();
  } else {
      $sliders = array();
  }

  foreach( $sliders as $slider => $alias) { 
    $slider_array[$alias] = htmlspecialchars($alias);
  }

  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'revslider_layout' => array(
                  'name' => __('Revolution Slider', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'revslider_layout',
                        'label' => 'Revolution Slider',
                        'type' => 'select',
                        'options' => $slider_array,
                        'value' => 'post-grid',
                        'description' => 'Choose a slider to display',
                        'admin_label' => true,
                      ),
                  )
              ), 
          )
      );   
  }  
}  

function revslider_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'revslider_layout' => '',   
    ), $atts) );

    $output = '';

    $output .= do_shortcode('[rev_slider alias="'.$revslider_layout.'"]');

    return $output;
}

add_shortcode('revslider_layout', 'revslider_layout_shortcode'); 

?>