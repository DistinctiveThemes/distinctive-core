<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_simple_button_block', 99 );

// BLOG FEED
function distinctpress_simple_button_block() { 
  
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
              'simple_button_layout' => array(
                  'name' => __('Simple Button', 'distinctpress'),
                  'icon' => 'dt-block-icon',
                  'category' => 'DistinctPress',
                  'params' => array(
                      array(
                          'name' => 'button_label',
                          'label' => 'Button Label',
                          'type' => 'text', 
                          'value' => 'Click Here',
                      ),
                      array(
                          'name' => 'button_url',
                          'label' => 'Button Url',
                          'type' => 'text', 
                          'value' => '',
                      ),
                      array(
                        'name' => 'button_links_to',
                        'label' => 'Link Button To:',
                        'type' => 'select',
                        'options' => array(
                             'url' => 'URL',
                             'image-lightbox' => 'Image Lightbox (Ensure URL Supplied above is an image)',
                             'video-lightbox' => 'Video Lightbox (Ensure URL Supplied above is oEmbed URL)',
                        ),
                        'value' => 'url',
                        'admin_label' => true,
                      ),
                      array(
                        'name' => 'button_alignment',
                        'label' => 'Alignment:',
                        'type' => 'select',
                        'options' => array(
                             'text-left' => 'Align Left',
                             'text-center' => 'Align Center',
                             'text-right' => 'Align Right',
                        ),
                        'value' => 'text-center',
                        'admin_label' => true,
                      ),
                  )
              ), 
          )
      );   
  }  
}  

function simple_button_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'button_label' => 'Click Here',
        'button_alignment' => 'text-center',
        'button_url' => '',  
        'button_links_to' => 'url',  
    ), $atts) );

    $output = '<div class="'.$button_alignment.'">';

    if ($button_links_to == 'url') {
        $output .= '<a class="btn" href="'.esc_url($button_url).'">'.esc_attr($button_label).'</a>';
    }

    if ($button_links_to == 'image-lightbox') {
        $output .= '<a class="btn gallery-lb" data-featherlight="'.esc_url($button_url).'" href="#">'.esc_attr($button_label).'</a>';
    }

    if ($button_links_to == 'video-lightbox') {
        $video_embed = $button_url;
        $embed = wp_oembed_get($video_embed); 
        preg_match('/src="([^"]+)"/', $embed, $match);
        $url = $match[1];
        $output .= '<a class="btn gallery-lb" href="'.esc_url($url).'" data-featherlight="iframe" data-featherlight-iframe-width="960" data-featherlight-iframe-height="540">'.esc_attr($button_label).'</a>';
    }

    $output .= '</div>';

    return $output;
}

add_shortcode('simple_button_layout', 'simple_button_layout_shortcode'); 

?>