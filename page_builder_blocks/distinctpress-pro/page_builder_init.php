<?php

/* LOAD OUR CUSTOM BLOCKS */
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/distinctpress-pro/blog_feed.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/distinctpress-pro/blog_carousel.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/distinctpress-pro/portfolio_feed.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/distinctpress-pro/portfolio_carousel.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/distinctpress-pro/team_feed.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/distinctpress-pro/team_carousel.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/distinctpress-pro/contact_form_7.php' );
require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/distinctpress-pro/comments.php' );

require_once( DISTINCTIVE_CORE_PATH . 'page_builder_blocks/distinctpress-pro/product_feed.php' );

//TESTER
add_action('init', 'prime_accordion_shortcode_init', 99 );
 
function prime_accordion_shortcode_init(){
 
    global $kc;
    $kc->add_map(
        array(
            'usa_accordion' => array(
                'name' => 'Accordion',
                'description' => __('flexible image before after shortcode', 'distinctpress'),
                'icon' => 'kc-icon-accordion',
                'css_box' => true,
                'category' => 'KC RD Extensions',
                'params' => array(
                // Title  Color
                    array(
                        'name' => 'title_color',
                        'label' => 'Title Color',
                        'type' => 'color_picker',
                        'admin_label' => true,
                        'value' => '#FFFFFF'
                    ),
                                // Title Background Color
                    array(
                        'name' => 'title_bg_color',
                        'label' => 'Title Background Color',
                        'type' => 'color_picker',
                        'admin_label' => true,
                        'value' => '#27AE60'
                    ),
                  // Description  Color
                    array(
                        'name' => 'descr_color',
                        'label' => 'Description Color',
                        'type' => 'color_picker',
                        'admin_label' => true,
                       
                        'value' => '#8c9195'
                    ),
                                       
                                        //Description Background Color
                                array(
                        'name' => 'descr_bg_color',
                        'label' => 'Description Background Color',
                        'type' => 'color_picker',
                        'admin_label' => true,
                        'value' => '#FAFAFA'
                    ),
                                       
                                        array(
                        'name' => 't_f_size',
                        'label' => 'Title Font Size',
                        'type' => 'number_slider',
                        'options' => array(
                            'min' => 1,
                            'max' => 30,
                            'unit' => 'px',
                            'show_input' => true,
                            'value' => '18'
                        ),
                        'description' => 'Title Font Size'
                    ),
                                       
                                                                               
                                        array(
                        'name' => 'd_f_size',
                        'label' => 'Description Font Size',
                        'type' => 'number_slider',
                        'options' => array(
                            'min' => 1,
                            'max' => 30,
                            'unit' => 'px',
                            'show_input' => true,
                            'value' => '14'
                        ),
                        'description' => 'Description Font Size'
                    ),
                               
    array(
            'type'            => 'group',
            'label'            => __('Add Accordion Items', 'distinctpress'),
            'name'            => 'acoptions',
            'description'    => __( 'Repeat this fields with each item created, Each item corresponding processbar element.', 'distinctpress' ),
                        'options'        => array('add_text' => __('Add new Items', 'distinctpress')),
                        /*
                                'value' => base64_encode( json_encode( array(
                                        "1" => array(
                                                "title" => "default value 1 of group 1",
                                                "acc_descr" => "default value 2 of group 1"
                                        ),
                                ))),
                        */
     
            'params' => array(
                    array(
                        'name' => 'title',
                        'label' => 'Title',
                        'type' => 'text',
                        'value' => 'Title Goes Here',
                    ),
               
                array(
                    'type'          => 'editor',
                    'label'         => __( 'Modal Box Description', 'distinctpress' ),
                    'name'          => 'acc_descr',
                    'description'   => __( 'Description of the Modal Box.', 'distinctpress' ),
                                        'value' => base64_encode('Sed posuere consectetur est at lobortis. Fusce dapibus, tellus ac cursus commodo.Cras mattis consectetur purus sit amet fermentum. Sed posuere consectetur est at lobortis. Fusce dapibus, tellus ac cursus commodo'),
                    'admin_label'   => true,
                ),                     
                array(
                        'name' => 'act_accordion',
                        'label' => 'Active Items',
                        'type' => 'checkbox',
                        'options' => array(
                     'active' => 'Yes',
                        )
                    ), 
                    ),
    ), 
                                       
                )
            )
        )
    );
} 
// Register Before After Shortcode
function prime_accordion_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
        'title' => '',
        'acc_descr' => '',
        'acc_bg_color' => '',
        't_f_size' => '',
        'd_f_size' => '',
        'title_bg_color' => '',
        'title_color' => '',
        'descr_bg_color' => '',
        'descr_color' => '',
        'act_accordion' => '',
       
    ), $atts) );
$acoptions = $atts['acoptions'];
//print_r($acoptions);
// echo $acoptions->title;
// $acc_descr = base64_decode( $atts['acc_descr'] );
$output = '<div class="accordion-wrapper">';
if( isset( $acoptions ) ){
       
  foreach( $acoptions as $option ){
         
$output .= '<div class="ac-pane '. $option->act_accordion.'">
                <a style="background-color:'.$title_bg_color.'; text-decoration:none; " href="#" class="ac-title" data-accordion="true">
                    <span style="font-size:'.$t_f_size.'; color:'.$title_color.';">'. $option->title.'</span>
                    <i class="fa"></i>
                </a>
                <div style="background:'.$descr_bg_color.';" class="ac-content">
                   <p style="font-size:'.$d_f_size.'; color:'.$descr_color.';"> '.$option->acc_descr.' </p>
                </div>
            </div>';     
  }
}
$output .='</div>';               
   
    return $output;
}
add_shortcode('usa_accordion', 'prime_accordion_shortcode'); 

?>