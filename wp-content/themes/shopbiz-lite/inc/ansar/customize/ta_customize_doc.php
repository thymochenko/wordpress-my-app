<?php
function shopbiz_icy_doc_setting( $wp_customize ) {
	$wp_customize->add_section( 'themeansar_store_setting', array(
        'title' => __('Themeansar Store','shopbiz'),
        'description' => '',
		'priority' => 1200,
	) );
}
add_action( 'customize_register', 'shopbiz_icy_doc_setting' );
?>