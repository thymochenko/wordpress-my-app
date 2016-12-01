<?php

function ad_mag_lite_page_navigation() {

	$options = array(
		'pages_text'                   => __( 'Page %CURRENT_PAGE% of %TOTAL_PAGES%', 'ad-mag-lite' ),
		'current_text'                 => '%PAGE_NUMBER%',
		'page_text'                    => '%PAGE_NUMBER%',
		'first_text'                   => __( '&laquo; First', 'ad-mag-lite' ),
		'last_text'                    => __( 'Last &raquo;', 'ad-mag-lite' ),
		'prev_text'                    => __( '&laquo; Prev', 'ad-mag-lite' ),
		'next_text'                    => __( 'Next &raquo;', 'ad-mag-lite' ),
		'dotleft_text'                 => __( '...', 'ad-mag-lite' ),
		'dotright_text'                => __( '...', 'ad-mag-lite' ),
		'num_pages'                    => 5,
		'num_larger_page_numbers'      => 3,
		'larger_page_numbers_multiple' => 10,
		'before'                       => '<div class="page-links-wrapper"><div class="page-links">',
		'after'                        => '</div></div>',
	);
	global $numpages;

	if($numpages <= 1) return;

	$posts_per_page = 1;
	$paged = max( 1, absint( get_query_var( 'page' ) ) );
	$total_pages = max( 1, $numpages );
	$pages_to_show = absint( $options['num_pages'] );
	$larger_page_to_show = absint( $options['num_larger_page_numbers'] );
	$larger_page_multiple = absint( $options['larger_page_numbers_multiple'] );
	$pages_to_show_minus_1 = $pages_to_show - 1;
	$half_page_start = floor( $pages_to_show_minus_1/2 );
	$half_page_end = ceil( $pages_to_show_minus_1/2 );
	$start_page = $paged - $half_page_start;
	$out ='';
	if ( $start_page <= 0 )
		$start_page = 1;

	$end_page = $paged + $half_page_end;

	if ( ( $end_page - $start_page ) != $pages_to_show_minus_1 )
		$end_page = $start_page + $pages_to_show_minus_1;

	if ( $end_page > $total_pages ) {
		$start_page = $total_pages - $pages_to_show_minus_1;
		$end_page = $total_pages;
	}

	if ( $start_page < 1 )
		$start_page = 1;

	if ( $start_page >= 2 && $pages_to_show < $total_pages ) {
		// First
		$first_text = str_replace( '%TOTAL_PAGES%', number_format_i18n( $total_pages ), $options['first_text'] );
		$out .= '<a href="'.ad_mag_lite_get_multipage_link( 1).'"><span>'.$first_text.'</span></a> ';
		 
	}
	// Previous
	if ( $paged > 1 && !empty( $options['prev_text'] ) ) {
		$out .= '<a href="'.ad_mag_lite_get_multipage_link($paged - 1).'"><span>'.$options['prev_text'].'</span></a> ';
	}
	if ( $start_page >= 2 && $pages_to_show < $total_pages ) {
		if ( !empty( $options['dotleft_text'] ) )
			$out .= "<span class='extend'>{$options['dotleft_text']}</span> ";
	}
	// Smaller pages
	$larger_pages_array = array();
	if ( $larger_page_multiple )
		for ( $i = $larger_page_multiple; $i <= $total_pages; $i+= $larger_page_multiple )
			$larger_pages_array[] = $i;
	$larger_page_start = 0;
	foreach ( $larger_pages_array as $larger_page ) {
		if ( $larger_page < ($start_page - $half_page_start) && $larger_page_start < $larger_page_to_show ) {
			$out .= '<a href="'.ad_mag_lite_get_multipage_link( $larger_page ).'">'.number_format_i18n($larger_page).'</a> ';
			$larger_page_start++;
		}
	}
	if ( $larger_page_start )
		$out .= "<span class='extend'>{$options['dotleft_text']}</span> ";
	// Page numbers
	$timeline = 'smaller';
	foreach ( range( $start_page, $end_page ) as $i ) {
		if ( $i == $paged && !empty( $options['current_text'] ) ) {
			$current_page_text = str_replace( '%PAGE_NUMBER%', number_format_i18n( $i ), $options['current_text'] );
			$out .= "<span class='current'>$current_page_text</span> ";
			$timeline = 'larger';
		} else {
			$out .= '<a href="'.ad_mag_lite_get_multipage_link($i).'"><span>'.number_format_i18n($i).'</span></a> ';
		}
	}
	// Large pages
	$larger_page_end = 0;
	$larger_page_out = '';
	foreach ( $larger_pages_array as $larger_page ) {
		if ( $larger_page > ($end_page + $half_page_end) && $larger_page_end < $larger_page_to_show ) {
			$larger_page_out .= '<a href="'.ad_mag_lite_get_multipage_link($larger_page).'"><span>'.number_format_i18n($larger_page).'</span></a> ';
			$larger_page_end++;
		}
	}
	if ( $larger_page_out ) {
		$out .= "<span class='extend'>{$options['dotright_text']}</span> ";
	}
	$out .= $larger_page_out;
	if ( $end_page < $total_pages ) {
		if ( !empty( $options['dotright_text'] ) )
			$out .= "<span class='extend'>{$options['dotright_text']}</span> ";
	}
	// Next
	if ( $paged < $total_pages && !empty( $options['next_text'] ) ) {
		$out .= '<a href="'.ad_mag_lite_get_multipage_link($paged + 1).'"><span>'.$options['next_text'].'</span></a> ';
	}
	if ( $end_page < $total_pages ) {
		// Lastl
		$out .= '<a href="'.ad_mag_lite_get_multipage_link($total_pages).'"><span>'.$options['last_text'].'</span></a>';
	}
			
	$out = $options['before'] . "\n$out\n" . $options['after'];
	

	echo wp_kses_post($out);
}

function ad_mag_lite_get_multipage_link( $page = 1 ) {
	global $post, $wp_rewrite;

	if ( 1 == $page ) {
		$url = get_permalink();
	} else {
		if ( '' == get_option('permalink_structure') || in_array( $post->post_status, array( 'draft', 'pending') ) )
			$url = add_query_arg( 'page', $page, get_permalink() );
		elseif ( 'page' == get_option( 'show_on_front' ) && get_option('page_on_front') == $post->ID )
			$url = trailingslashit( get_permalink() ) . user_trailingslashit( $wp_rewrite->pagination_base . "/$page", 'single_paged' );
		else
			$url = trailingslashit( get_permalink() ) . user_trailingslashit( $page, 'single_paged' );
	}

	return $url;
}

ad_mag_lite_page_navigation();