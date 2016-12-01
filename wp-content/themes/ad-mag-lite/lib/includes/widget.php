<?php
add_action('admin_enqueue_scripts', 'ad_mag_lite_widget_admin_enqueue_scripts');

function ad_mag_lite_widget_admin_enqueue_scripts($hook) {
	if ('widgets.php' === $hook) {
		$dir = get_template_directory_uri() . '/lib/includes/widgets';
		wp_enqueue_style('ad_mag_lite_widget_admin', "{$dir}/css/widget.css");
		wp_enqueue_script('ad_mag_lite_widget_admin', "{$dir}/js/widget.js", array('jquery'));
	}
}

function ad_mag_lite_widget_posttype_build_query( $query_args = array() ) {
	$default_query_args = array(
		'post_type'           => 'post',
		'posts_per_page'      => -1,
		'post__not_in'        => array(),
		'ignore_sticky_posts' => 1,
		'categories'          => array(),
		'tags'                => array(),
		'relation'            => 'OR',
		'post_format'         => '',
		'orderby'             => 'latest',
		'cat_name'            => 'category',
		'tag_name'            => 'post_tag'
		);

	$query_args = wp_parse_args( $query_args, $default_query_args );

	$args = array(
		'post_type'           => $query_args['post_type'],
		'posts_per_page'      => $query_args['posts_per_page'],
		'post_format'         => $query_args['post_format'],
		'post__not_in'        => $query_args['post__not_in'],
		'ignore_sticky_posts' => $query_args['ignore_sticky_posts']
		);

	$tax_query = array();

	if ( $query_args['categories'] ) {
		$tax_query[] = array(
			'taxonomy' => $query_args['cat_name'],
			'field'    => 'id',
			'terms'    => $query_args['categories']
			);
	}
	if ( $query_args['tags'] ) {
		$tax_query[] = array(
			'taxonomy' => $query_args['tag_name'],
			'field'    => 'id',
			'terms'    => $query_args['tags']
			);
	}
	if ( $query_args['relation'] && count( $tax_query ) == 2 ) {
		$tax_query['relation'] = $query_args['relation'];
	}
	if ( $query_args['post_format'] ) {
		$tax_query[] = array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( $query_args['post_format'] )
			);
	}

	if ( isset($query_args['date_query']) && $query_args['date_query'] ){
		global $wp_version;
		$timestamp =  $query_args['date_query'];
		if (version_compare($wp_version, '3.7.0', '>=')) {
			if (isset($timestamp) && !empty($timestamp)) {
				$y = date('Y', strtotime($timestamp));
				$m = date('m', strtotime($timestamp));
				$d = date('d', strtotime($timestamp));
				$args['date_query'] = array(
					array(
						'after' => array(
							'year' => (int) $y,
							'month' => (int) $m,
							'day' => (int) $d
							)
						)
					);
			}
		}
	}

	if ( $tax_query ) {
		$args['tax_query'] = $tax_query;
	}

	switch ( $query_args['orderby'] ) {
		case 'most_comment':
		$args['orderby'] = 'comment_count';
		break;
		case 'random':
		$args['orderby'] = 'rand';
		break;
		default:
		$args['orderby'] = 'date';
		break;
	}

	return new WP_Query( $args );
}

// Widgets
get_template_part('lib/includes/widgets/post/widget', 'article-list');
get_template_part('lib/includes/widgets/others/widget', 'editor');
get_template_part('lib/includes/widgets/others/widget', 'follow');
get_template_part('lib/includes/widgets/comment/widget', 'comments');