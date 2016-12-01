<?php
/**
 * shopbiz functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package shopbiz
 */


	$shopbiz_theme_path = get_template_directory() . '/inc/ansar/';

	require( $shopbiz_theme_path . '/shopbiz-custom-navwalker.php' );
	require( $shopbiz_theme_path . '/widget/shopbiz-service.php');
	require( $shopbiz_theme_path . '/font/font.php');

	/*-----------------------------------------------------------------------------------*/
	/*	Enqueue scripts and styles.
	/*-----------------------------------------------------------------------------------*/
	require( $shopbiz_theme_path .'/enqueue.php');
	/* ----------------------------------------------------------------------------------- */
	/* Customizer */
	/* ----------------------------------------------------------------------------------- */
	
	require( $shopbiz_theme_path . '/customize/ta_customize_copyright.php');
	require( $shopbiz_theme_path . '/customize/ta_customize_theme_style.php');
	require( $shopbiz_theme_path . '/customize/ta_customize_homepage.php');
	require( $shopbiz_theme_path . '/customize/ta_customize_doc.php');
	require( $shopbiz_theme_path . '/customize/ta_customize_developer.php');
	require( $shopbiz_theme_path . '/customize/ta_customize_pro.php');

if ( ! function_exists( 'shopbiz_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function shopbiz_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on shopbiz, use a find and replace
	 * to change 'shopbiz' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'shopbiz', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	
	//Custom logo Support
	add_theme_support( 'custom-logo' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary menu', 'shopbiz' ),
        'footer' => __( 'Footer Menu', 'shopbiz' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'shopbiz_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

    // Set up the woocommerce feature.
    add_theme_support( 'woocommerce');

}
endif;
add_action( 'after_setup_theme', 'shopbiz_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function shopbiz_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'shopbiz_content_width', 640 );
}
add_action( 'after_setup_theme', 'shopbiz_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function shopbiz_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'shopbiz' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="ta-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6>',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area', 'shopbiz' ),
		'id'            => 'footer_widget_area',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="col-md-3 col-sm-6 rotateInDownLeft animated ta-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6>',
		'after_title'   => '</h6>',
	) );
	
	register_sidebar( array(
		'name' => __('shopbiz service widget','shopbiz'),
		'id' => 'shopbiz_service_widget',
		'discription' => __('shopbiz Service widget','shopbiz'),
		'before_widget' => '<div id="%1$s" class="col-md-4 service_area widget wow swing  animated %1$s">',
		'after_widget' => '</div>',
));
	
}
add_action( 'widgets_init', 'shopbiz_widgets_init' );


function shopbiz_enqueue_customizer_admin_scripts() {
  wp_register_script( 'customizer-admin-js', get_template_directory_uri() . '/js/admin/customizer-admin.js', array( 'jquery' ), NULL, true );
  wp_enqueue_script( 'customizer-admin-js' );
  }
add_action( 'admin_enqueue_scripts', 'shopbiz_enqueue_customizer_admin_scripts' );


function shopbiz_enqueue_customizer_controls_styles() {
  wp_register_style( 'shopbiz-customizer-controls', get_template_directory_uri() . '/css/customizer-controls.css', NULL, NULL, 'all' );
  wp_enqueue_style( 'shopbiz-customizer-controls' );
  }
add_action( 'customize_controls_print_styles', 'shopbiz_enqueue_customizer_controls_styles' );


/* Custom template tags for this theme. */
require get_template_directory() . '/inc/ansar/template-tags.php';


/* custom-color file. */
require( get_template_directory() . '/css/colors/custom-color.php');


add_filter( 'post_thumbnail_html', 'shopbiz_remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'shopbiz_remove_width_attribute', 10 );

function shopbiz_remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}

//Read more Button on slider & Post
function shopbiz_read_more() {
	
	global $post;
	
	$readbtnurl = '<a class="btn btn-tislider-two" href="' . get_permalink() . '">'.__( 'Read More' , 'shopbiz' ).'</a>';
	
    return $readbtnurl;
}
add_filter( 'the_content_more_link', 'shopbiz_read_more' );

/* Calling in the admin area for the Welcome Page */
if ( is_admin() ) {
	require get_template_directory() . '/inc/ansar/themeinfo/themeinfo-detail.php';
}