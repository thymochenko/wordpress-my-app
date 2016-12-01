<?php

// Helper library for the theme customizer.
load_template( trailingslashit( get_template_directory() ) . 'admin/customizer-library/customizer-library.php');
// Define options for the theme customizer.
load_template( trailingslashit( get_template_directory() ) . 'admin/customizer-options.php');
// Output inline styles based on theme customizer selections.
load_template( trailingslashit( get_template_directory() ) . 'admin/styles.php');
// Additional filters and actions based on theme customizer selections.
load_template( trailingslashit( get_template_directory() ) . 'admin/mods.php');


if ( ! function_exists( 'avata_setup' ) ) :

function avata_setup() {
	
	global $content_width, $avata_options;
    $avata_options = get_theme_mods();
	
	if ( ! isset( $content_width ) ) {
		$content_width = 1170; /* pixels */
	}
	
	load_theme_textdomain( 'avata' );

    add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_editor_style("editor-style.css");
    add_post_type_support( 'page', 'excerpt' );
	
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'avata' ),
		'footer_menu' => __( 'Footer Menu', 'avata' ),
	) );
	

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );
	
	add_theme_support( 'custom-header', array(
        'default-image'          => '',
        'random-default'         => false,
        'width'                  => '1920',
        'height'                 => '120',
        'flex-height'            => true,
        'flex-width'             => true,
        'default-text-color'     => 'd54e21',
        'header-text'            => true,
        'uploads'                => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => ''
)); 

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'avata_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
	add_theme_support( 'custom-logo', array(
	'height'      => 50,
	'width'       => 50,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( 'site-title', 'site-description' ),
) );
	
	add_editor_style( array( 'assets/css/editor-style.css', 'assets/fonts/genericons/genericons.css' ) );

}
endif; // avata_setup
add_action( 'after_setup_theme', 'avata_setup' );


/**
 * Enqueue scripts and styles.
 */
function avata_scripts() {
	global $content_width,$post,$avata_homepage_sections;

	$theme_info = wp_get_theme();
	
 wp_enqueue_style( 'avata-rokkitt', esc_url('http://fonts.googleapis.com/css?family=Rokkitt:400,700|Open+Sans:400,300italic,300,400italic,600,600italic,700,700italic,800,800italic, false'), '', false );
 wp_enqueue_style( 'font-awesome',  get_template_directory_uri() .'/assets/fonts/font-awesome/css/font-awesome.min.css', false, '', false );
 wp_enqueue_style( 'bootstrap',  get_template_directory_uri() .'/assets/bootstrap/css/bootstrap.css', false, '', false );
 wp_enqueue_style( 'avata-main', get_stylesheet_uri() );
 
 $avata_custom_css = '';
 foreach(  $avata_homepage_sections as $k=>$v ){
	 $color            = avata_option('section_'.$k.'_color');
	 $background_color = avata_option('section_'.$k.'_background_color');
	 $background_image = avata_option('section_'.$k.'_background_image');
	 $top_padding      = avata_option('section_'.$k.'_top_padding');
	 $bottom_padding   = avata_option('section_'.$k.'_bottom_padding');
	 $min_height       = avata_option('section_'.$k.'_min_height');
	 $background_repeat= avata_option('section_'.$k.'_background_repeat');
	 $background_full  = avata_option('section_'.$k.'_background_full');
	 $avata_custom_css .= ".section-".$k." div,.section-".$k." p,.section-".$k." h1,.section-".$k." h2{\r\n";
	 $avata_custom_css .= "color:".$color.";\r\n";
	 $avata_custom_css .= "}\r\n";
	 $avata_custom_css .= ".section-".$k."{\r\n";
	 $avata_custom_css .= "padding-top:".$top_padding.";\r\n";
	 $avata_custom_css .= "padding-bottom:".$bottom_padding.";\r\n";
	 $avata_custom_css .= "background-color:".$background_color.";\r\n";
	 $avata_custom_css .= "background-repeat:".$background_repeat.";\r\n";
	 $avata_custom_css .= "background-image:url(".$background_image.");\r\n";
	 
	 if( $background_full == '1' )
	  $avata_custom_css  .= "-webkit-background-size: cover;\r\n -moz-background-size: cover;\r\n -o-background-size: cover;\r\n background-size: cover;\r\n";
	 $avata_custom_css .= "min-height:".$min_height.";\r\n";
	 $avata_custom_css .= "}\r\n";
 }
// Header 
	if(get_header_textcolor()=='blank'){
		    $avata_custom_css .= ".site-name,.site-tagline{display: none;}";
		}else{
			$avata_custom_css .= ".site-name a,.site-tagline{color:#".get_header_textcolor()." !important;}";
			}

	

 wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.js', array( 'jquery' ), null, false );
 wp_enqueue_script( 'hoverIntent', get_template_directory_uri() . '/assets/js/hoverIntent.js', array( 'jquery' ), null, true );
 wp_enqueue_script( 'superfish', get_template_directory_uri() . '/assets/js/superfish.js', array( 'jquery' ), null, true );
 wp_enqueue_script( 'jquery.meanmenu', get_template_directory_uri() . '/assets/js/jquery.meanmenu.js', array( 'jquery' ), null, true );
 wp_enqueue_script( 'avata-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ),  $theme_info->get( 'Version' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
 
 $custom_css        = wp_filter_nohtml_kses(avata_option('custom_css'));
 $avata_custom_css .=  $custom_css;
 wp_add_inline_style( 'avata-main', $avata_custom_css );
	
}
add_action( 'wp_enqueue_scripts', 'avata_scripts' );

require get_template_directory() . '/inc/template-tags.php';


/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
