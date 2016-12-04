<?php
/* Load Omega theme framework. */
require ( trailingslashit( get_template_directory() ) . 'lib/framework.php' );
new Omega();

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */

function omega_theme_setup() {

	//remove_theme_mods();

	/* Load omega functions */
	require get_template_directory() . '/lib/functions/hooks.php';

	add_theme_support( 'title-tag' ); 
	
	/* Load scripts. */
	add_theme_support( 
		'omega-scripts', 
		array( 'comment-reply' ) 
	);
	
	add_theme_support( 'post-thumbnails' );
	
	add_theme_support( 'omega-theme-settings' );

	add_theme_support( 'omega-content-archives' );
		
	/* implement editor styling, so as to make the editor content match the resulting post output in the theme. */
	add_editor_style();

	/* Support pagination instead of prev/next links. */
	add_theme_support( 'loop-pagination' );	

	/* Add default posts and comments RSS feed links to <head>.  */
	add_theme_support( 'automatic-feed-links' );

	/* Enable wraps */
	add_theme_support( 'omega-wraps' );

	/* Enable custom post */
	add_theme_support( 'omega-custom-post' );
	
	/* Enable custom css */
	add_theme_support( 'omega-custom-css' );
	
	/* Enable custom logo */
	add_theme_support( 'omega-custom-logo' );

	/* Enable child themes page */
	add_theme_support( 'omega-child-page' );

	add_theme_support( 'woocommerce' );

	/* Handle content width for embeds and images. */
	omega_set_content_width( 700 );

}

add_action( 'after_setup_theme', 'omega_theme_setup' );


/**
 * Display LifterLMS Course and Lesson sidebars
 * on courses and lessons in place of the sidebar returned by
 * this function
 * @param    string     $id    default sidebar id (an empty string)
 * @return   string
 */
function my_llms_sidebar_function( $id ) {
	$my_sidebar_id = 'primary'; // replace this with your theme's sidebar ID
	return $my_sidebar_id;
}

add_filter( 'llms_get_theme_default_sidebar', 'my_llms_sidebar_function' );

/**
 * Declare explicit theme support for LifterLMS course and lesson sidebars
 * @return   void
 */
function my_llms_theme_support(){
	add_theme_support( 'lifterlms-sidebars' );
}

add_action( 'after_setup_theme', 'my_llms_theme_support' );


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

