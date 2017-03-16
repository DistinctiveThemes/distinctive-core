<?php

/* ADD OUR BLOCKS */
add_action('init', 'distinctpress_media_grid_shortcode_init', 99 );
 
function distinctpress_media_grid_shortcode_init() {
 
   if (function_exists('kc_add_map')) { 
      kc_add_map(
        array(
            'media_grid_layout' => array(
                'name' => 'Media Grid',
                'description' => __('Handy for showing images and videos', 'distinctpress'),
                'icon' => 'dt-block-icon',
                'css_box' => true,
                'category' => 'DistinctPress',
                'params' => array(                  
                    array(
                      'name' => 'grid_layout',
                      'label' => 'Grid Layout',
                      'type' => 'select',
                      'options' => array(
                           'col-sm-6' => 'Grid 2 Columns',
                           'col-sm-4' => 'Grid 3 Columns',
                           'col-sm-3' => 'Grid 4 Columns',
                      ),
                      'value' => 'col-sm-4',
                      'description' => 'Choose how you wish to display your items.',
                      'admin_label' => true,
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
                              'name' => 'link_to',
                              'label' => 'Link Image To:',
                              'type' => 'select',
                              'options' => array(
                                   'nothing' => 'No Link',                                   
                                   'url' => 'Custom URL (Enter URL Below)',
                                   'lightbox' => 'Image Lightbox (Image Supplied Above)',
                                   'lightbox-video' => 'Video Lightbox (Enter embed link Below)',
                              ),
                              'value' => 'nothing',
                              'admin_label' => true,
                            ),   
                            array(
                                'name' => 'item_link',
                                'label' => 'URL/Embed Link',
                                'type' => 'text', 
                                'value' => '',
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
function distinctpress_media_grid_layout_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'grid_layout' => 'col-sm-4',
        'link_to' => 'nothing',
        'item_link' => '',
       
    ), $atts) );

    $acoptions = $atts['acoptions']; 

    ob_start(); ?>

    <div class="row">

    <?php if( isset( $acoptions ) ) {
           
      foreach( $acoptions as $option ) {

        $slide_image = wp_get_attachment_image_src($option->image, 'distinctpress-full-featured-square');

        ?>

        <div class="<?php echo esc_attr($grid_layout); ?> mb30">
          <div class="item-padder">
            <div class="entry-featured-image">

              <?php if(isset($slide_image[0])) { ?>

                <img src="<?php echo esc_url($slide_image[0]); ?>">  

                <?php if ($option->link_to !== 'nothing') { ?>
                <div class="image-rollover" data-featherlight-gallery data-featherlight-filter="a">
                  <div class="vertical-center-js">

                      <?php
                      if ($option->link_to == 'lightbox-video') {
                        $video_embed = $option->item_link;
                        $embed = wp_oembed_get($video_embed); 
                        preg_match('/src="([^"]+)"/', $embed, $match);
                        $url = $match[1];
                        ?>
                        <a href="<?php echo esc_url($url); ?>" data-featherlight="iframe" data-featherlight-iframe-width="960" data-featherlight-iframe-height="540">
                          <i class="ion-ios-plus-empty"></i>
                        </a>
                      <?php 
                      } elseif ($option->link_to == 'lightbox') { ?>
                        <a href="#" data-featherlight="<?php echo esc_url($slide_image[0]); ?>">
                          <i class="ion-ios-plus-empty"></i>
                        </a>
                      <?php } elseif ($option->link_to == 'url') { ?>
                        <a href="<?php echo esc_url($option->item_link); ?>">
                          <i class="ion-ios-plus-empty"></i>
                        </a>
                      <?php } ?>
                  </div>
                </div>
                <?php } ?>

              <?php } ?>

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

add_shortcode('media_grid_layout', 'distinctpress_media_grid_layout_shortcode'); 

?>