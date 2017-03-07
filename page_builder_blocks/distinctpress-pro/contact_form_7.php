<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_contact_form_7_block', 99 );

// BLOG FEED
function distinctpress_contact_form_7_block() { 

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

  if (function_exists('kc_add_map')) { 
      kc_add_map(
          array( 
              'contact_form_7_layout' => array(
                  'name' => __('Contact Form 7', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                        'name' => 'contact_form_7_layout',
                        'label' => 'Contact Form 7',
                        'type' => 'select',
                        'options' => $form_array,
                        'value' => 'post-grid',
                        'description' => 'Choose how you wish to display your news.',
                        'admin_label' => true,
                      ),
                  )
              ), 
          )
      );   
  }  
}  

function contact_form_7_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'contact_form_7_layout' => '',   
    ), $atts) );

    $output = '';

    $output .= do_shortcode('[contact-form-7 id="'.$contact_form_7_layout.'"]');

    wp_reset_postdata();

    return $output;
}

add_shortcode('contact_form_7_layout', 'contact_form_7_layout_shortcode'); 

?>