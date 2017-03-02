<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_hero_slider_shortcode_init', 99 );
 
function distinctpress_hero_slider_shortcode_init() {
 
   if (function_exists('kc_add_map')) { 
      kc_add_map(
        array(
            'hero_slider_layout' => array(
                'name' => 'Hero Slider',
                'description' => __('A simple image slider', 'distinctpress'),
                'icon' => 'dt-block-icon',
                'css_box' => true,
                'category' => 'DistinctPress',
                'params' => array(                  
                    array(
                      'name' => 'max_height',
                      'label' => 'Max Height (in vh)',
                      'type' => 'text', 
                      'value' => '100vh',
                    ),
                    array(
                        'type' => 'group',
                        'label' => __('Add Accordion Items', 'distinctpress'),
                        'name' => 'acoptions',
                        'description' => __( 'Repeat this fields with each item created, Each item corresponding processbar element.', 'distinctpress' ),
                        'options' => array('add_text' => __('Add new Items', 'distinctpress')),
                        'params' => array(                                               
                            array(
                                'name' => 'image',
                                'label' => 'Upload Image',
                                'type' => 'attach_image',
                                'admin_label' => true,
                            ),     
                            array(
                                'name' => 'overlay_color',
                                'label' => 'Overlay Color',
                                'type' => 'color_picker',
                                'admin_label' => true,
                                'value' => 'rgba(0, 0, 0, 0.5)'
                            ),                
                            array(
                                'type'          => 'editor',
                                'label'         => __( 'Hero Content', 'distinctpress' ),
                                'name'          => 'content',
                                'description'   => __( 'Hero content area', 'distinctpress' ),
                                'value' => '',
                                'admin_label'   => true,
                            ),
                        ),
                    ), 
                                         
                  )
              )
          )
      );
  }
} 

// Register Before After Shortcode
function distinctpress_hero_slider_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'title' => '',
        'content' => '',
        'overlay_color' => 'rgba(0, 0, 0, 0.5)',
        'image'=> '',
        'max_height' => '100vh'
       
    ), $atts) );

    $acoptions = $atts['acoptions']; 

    ob_start(); ?>

    <div class="slick-carousel dots-inner slide negative-left-right" data-slick='{"slidesToShow": 1 , "dots": true, "arrows": false, "adaptiveHeight": true, "autoplay": true, "fade" :true}' data-items-1024-down="1" data-items-600-down="1" data-items-480-down="1">

    <?php if( isset( $acoptions ) ) {
           
      foreach( $acoptions as $option ) {

        $slide_image = wp_get_attachment_image_src($option->image, 'full');

        ?>
             
        <div class="background-cover fullheight" style="background-image: url('<?php echo esc_url($slide_image[0]); ?>'); max-height: <?php echo esc_attr($max_height); ?>;">
          <div class="overlay-layer" style="background-color: <?php echo esc_attr($option->overlay_color); ?>;">
            <div class="container fullheight" style="max-height: <?php echo esc_attr($max_height); ?>;">
              <div class="vertical-center-js">
                  <?php echo do_shortcode($option->content); ?>
              </div>
            </div>
          </div>
        </div>

        <?php  

      }
    }

    ?>

    </div>

    <?php 

    $output = ob_get_contents();

    ob_end_clean();              
       
    return $output;
}

add_shortcode('hero_slider_layout', 'distinctpress_hero_slider_layout_shortcode'); 

?>