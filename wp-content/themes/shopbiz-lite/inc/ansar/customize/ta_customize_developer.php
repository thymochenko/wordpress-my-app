<?php
//shopbiz Developer Settings
function shopbiz_developer_customizer( $wp_customize ) {
    $wp_customize->add_section( 'shopbiz_developer_section' , array(
		'title' => __('Developer Mode Settings', 'shopbiz'),
		'priority' => 2000,
   	) );

    $wp_customize->add_setting( 'custom_style', array(
        'sanitize_callback' => 'shopbiz_custom_sanitize_text',
    ) );
    $wp_customize->add_control( 'custom_style', array(
        'label'   => __('Custom css', 'shopbiz'),
        'section' => 'shopbiz_developer_section',
        'type' => 'textarea',
    ) );	

    $wp_customize->add_setting( 'shopbiz_developer_js', array(
		'sanitize_callback' => 'shopbiz_custom_sanitize_text',
    ) );

    $wp_customize->add_control( 'shopbiz_developer_js', array(
        'type' => 'textarea',
        'label' => __('Custom JS  ','shopbiz'),
        'section' => 'shopbiz_developer_section',
	) );
	
	
	
	function shopbiz_custom_sanitize_text( $input ) {

    return wp_kses_post( force_balance_tags( $input ) );

	}
	
	function shopbiz_custom_sanitize_html( $input ) {

    return force_balance_tags( $input );

	}
	
	
	
	
}
add_action( 'customize_register', 'shopbiz_developer_customizer' );
?>