<?php

add_shortcode( 'distinctive-button', 'distinctive_button_shortcode' );

function distinctive_button_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'button_style' => 'btn',
		'button_label' => '',
		'button_url' => '',
	), $atts ) );

	ob_start(); ?>

	<a class="btn <?php echo esc_attr($button_style); ?>" href="<?php echo esc_url($button_url); ?>"><?php echo esc_attr($button_label); ?></a>

	<?php return ob_get_clean();

}

add_shortcode( 'distinctive-lead-text', 'distinctive_lead_text_shortcode' );

function distinctive_lead_text_shortcode( $atts , $content = null ) {
	extract( shortcode_atts( array(
	), $atts ) );

	ob_start(); ?>

	<p class="lead"><?php echo wp_kses_post($content); ?></p>

	<?php return ob_get_clean();

}

?>