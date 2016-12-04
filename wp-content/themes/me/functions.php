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



/**
 * Custom post type - Book
 */
function book_init() {
	$labels = array(
		'name' => 'Books',
		'singular_name' => 'Book',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Book',
		'edit_item' => 'Edit Book',
		'new_item' => 'New Book',
		'view_item' => 'View Book',
		'search_items' => 'Search Books',
		'not_found' =>  'No books found',
		'not_found_in_trash' => 'No books found in Trash'
	);

	$args = array(
		'labels' => $labels,
		'description' => 'A custom post type that holds my books',
		'public' => true,
		'rewrite' => array('slug' => 'books'),
		'has_archive' => true,
		'taxonomies' => array('book_category'),
		'supports' => array('title', 'editor', 'author', 'excerpt', 'custom-fields', 'thumbnail')
	);
	register_post_type('book', $args);
	flush_rewrite_rules();
}

add_action('init', 'book_init');

/**
 * Admin messages for your custom post type
 */
function book_updated_messages( $messages ) {
	$messages['book'] = array(
		'', /* Unused. Messages start at index 1. */
		sprintf('Book updated. <a href="%s">View book</a>', esc_url(get_permalink($post_ID))),
		'Custom field updated.',
		'Custom field deleted.',
		'Book updated.',
		(isset($_GET['revision']) ? sprintf('Book restored to revision from %s', wp_post_revision_title((int)$_GET['revision'], false)) : false),
		sprintf('Book published. <a href="%s">View book</a>', esc_url(get_permalink($post_ID))),
		'Book saved.',
		sprintf('Book submitted. <a target="_blank" href="%s">Preview book</a>', esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
		sprintf('Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>', date_i18n('M j, Y @ G:i', strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
		sprintf('Book draft updated. <a target="_blank" href="%s">Preview book</a>', esc_url(add_query_arg('preview', 'true', get_permalink($post_ID))))
	);
	return $messages;
}

add_filter('post_updated_messages', 'book_updated_messages');

/**
 * Custom taxonomy for books
 */
function build_taxonomies() {
	register_taxonomy(
		'book_category',
		'book',
		array(
			'hierarchical' => true,
			'label' => 'Book Category',
			'query_var' => true,
			'rewrite' => array('slug' => 'available-books')
		)
	);
}

add_action('init', 'build_taxonomies', 0);
