<?php
/**
 * Beta functions and definitions
 *
 * @package Me
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function me_theme_setup() {
	
	remove_action( 'omega_footer', 'omega_footer_insert' );

	/* Load the primary menu. */
	remove_action( 'omega_before_header', 'omega_get_primary_menu' );	

		/* Add support for a custom header image. */
	add_theme_support(
		'custom-header',
		array( 'header-text' => false,
			'flex-width'    => true,
			'uploads'       => true,
			'default-image' => get_stylesheet_directory_uri() . '/images/header.jpg'
			));

	add_action( 'omega_header', 'omega_get_primary_menu' );
	add_action( 'after_primary', 'omega_footer_insert' );

	remove_action( 'omega_after_main', 'omega_primary_sidebar' );
	add_action( 'omega_before_footer', 'omega_primary_sidebar' );

	add_action( 'omega_header', 'me_theme_gravatar', 5 );

	load_child_theme_textdomain( 'me', get_stylesheet_directory() . '/languages' );

	add_action( 'wp_enqueue_scripts', 'me_theme_scripts_styles' );
}

add_action( 'after_setup_theme', 'me_theme_setup', 11 );


/**
 * if set, retrieve image from get_header_image. otherwise get the avatar from site admin email address.
 */

function me_theme_gravatar() {

	$header_image = get_header_image() ? '<img alt="" src="' . esc_url ( get_header_image() ) . '" />' : get_avatar( get_option( 'admin_email' ), 224 );
	printf( '<div class="site-avatar"><a href="%s">%s</a></div>', esc_url( home_url( '/' ) ), $header_image );

}

/**
 * Enqueue scripts and styles
 */

function me_theme_scripts_styles() {
	$query_args = array(
	 'family' => 'Alegreya:400|Lato:400'
	);
 	wp_enqueue_style('me-google-fonts', esc_url( add_query_arg( $query_args, "//fonts.googleapis.com/css" ) ), array(), null );
 	wp_enqueue_script('me-menu', get_stylesheet_directory_uri() . '/js/menu.js', array('jquery'), '1.0.0', true );
 	wp_enqueue_script('me-init', get_stylesheet_directory_uri() . '/js/init.js', array('jquery'));
}

