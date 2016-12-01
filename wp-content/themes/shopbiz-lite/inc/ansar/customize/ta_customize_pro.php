<?php
//Pro Button

function shopbiz_pro_customizer( $wp_customize ) {
    class WP_Pro_Customize_Control extends WP_Customize_Control {
    public $type = 'new_menu';
    /**
    * Render the control's content.
    */
    
    public function render_content() {
    ?>
     <div class="ta-pro-box">
       <a href="<?php echo esc_url( __('https://themeansar.com/themes/shopbiz/', 'shopbiz'));?>" target="_blank" class="upgrade" id="review_pro"> <?php _e( 'Upgrade To Pro','shopbiz' ); ?></a>
        
    </div>
    <?php
    }
}
    $wp_customize->add_section( 'shopbiz_pro_section' , array(
		'title' => __('Themeansar Store', 'shopbiz'),
		'priority' => 2100,
   	) );

    $wp_customize->add_setting('upgrade_pro', array(
        'default' => '',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new WP_Pro_Customize_Control( $wp_customize, 'upgrade_pro', array(
		'label' => __('Discover shopbiz Pro','shopbiz'),
        'section' => 'shopbiz_pro_section',
		'setting' => 'upgrade_pro',)
    ) );

class WP_Review_Customize_Control extends WP_Customize_Control {
    public $type = 'new_menu';
    /**
    * Render the control's content.
    */
    public function render_content() {
    ?>
	<div class="ta-pro-box">
        <a href="<?php echo esc_url( __('https://wordpress.org/support/theme/shopbiz-lite/reviews/#new-post/', 'shopbiz'));?>" target="_blank" class="review" id="review_pro"><?php _e( 'Support Forum','shopbiz' ); ?></a>
	</div>
    <?php
    }
}

    $wp_customize->add_setting( 'pro_Review', array(
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( new WP_Review_Customize_Control( $wp_customize, 'pro_Review', array(	
		'label' => __('Discover shopbiz Pro','shopbiz'),
        'section' => 'shopbiz_pro_section',
		'setting' => 'pro_Review',)
    ) );

class WP_document_Customize_Control extends WP_Customize_Control {
    public $type = 'new_menu';
    /**
    * Render the control's content.
    */
    public function render_content() {
    ?>
      <div class="ta-pro-box">
	 <a href="<?php echo esc_url( __('https://themeansar.com/help/', 'shopbiz'));?>" target="_blank" class="document" id="review_pro"><?php _e( 'Online Documenation','shopbiz' ); ?></a>
	 
	 <div>
    <?php
    }
}

    class WP_tistore_Customize_Control extends WP_Customize_Control {
    public $type = 'new_menu';
    /**
    * Render the control's content.
    */
    public function render_content() {
    ?>
      <div class="ta-pro-box">
     <a href="<?php echo esc_url( __('https://themeansar.com/themes/', 'shopbiz'));?>" target="_blank" class="tistore" id="ti_store"><?php _e( 'Explore Our Themes','shopbiz' ); ?></a>
     
     <div>
    <?php
    }
}

    

    $wp_customize->add_setting( 'doc_Review', array(
        'default' => '',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( new WP_document_Customize_Control( $wp_customize, 'doc_Review', array(	
		'label' => __('Discover shopbiz Pro','shopbiz'),
        'section' => 'shopbiz_pro_section',
		'setting' => 'doc_Review',)
    ) );

    $wp_customize->add_setting( 'ti_store', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( new WP_tistore_Customize_Control( $wp_customize, 'ti_store', array(  
        'label' => __('Discover shopbiz Pro','shopbiz'),
        'section' => 'shopbiz_pro_section',
        'setting' => 'ti_store',)
    ) );

}
add_action( 'customize_register', 'shopbiz_pro_customizer' );
?>