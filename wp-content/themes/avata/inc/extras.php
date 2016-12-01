<?php
// get option
function avata_option( $name, $default = false ) {
	   global $avata_options,$avata_default_options;
	   
	   $name = 'avata_'.$name;
	   if( $default == false )
	   $default = isset($avata_default_options[$name])?$avata_default_options[$name]:$default;
	   
		if ( isset( $avata_options[$name] ) ) {
				return apply_filters( "theme_mod_{$name}", $avata_options[$name] );
		}

		if ( is_string( $default ) )
				$default = sprintf( $default, get_template_directory_uri(), get_stylesheet_directory_uri() );
		return apply_filters( "theme_mod_{$name}", $default );
}

// get top bar content

 function avata_get_topbar_content( $type =''){
     global $allowedposttags;
	 switch( $type ){
		 case "info":
		 echo '<div class="top-bar-info">';
		 echo wp_kses(avata_option('top_bar_info_content'), $allowedposttags);
		 echo '</div>';
		 break;
		 case "sns":
		 $tooltip_position = avata_option('top_social_tooltip_position','bottom'); 
		 echo avata_get_social('header','top-bar-sns',$tooltip_position);
		 break;
		 case "menu":
		 echo '<nav class="top-bar-menu">';
		 wp_nav_menu(array('theme_location'=>'top_bar_menu','depth'=>1,'fallback_cb' =>false,'container'=>'','container_class'=>'','menu_id'=>'','menu_class'=>'','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
		 echo '</nav>';
		 break;
		 case "none":
		
		 break;
		 }
	 }


/**
 * Modifies WordPress's built-in comments_popup_link() function to return a string instead of echo comment results
 */
function avata_get_comments_popup_link( $zero = false, $one = false, $more = false, $avata_css_class = '', $none = false ) {
    global $wpcommentspopupfile, $wpcommentsjavascript;
 
    $id = get_the_ID();
 
    if ( false === $zero ) $zero = __( 'No Comments', 'avata');
    if ( false === $one ) $one = __( '1 Comment', 'avata');
    if ( false === $more ) $more = __( '% Comments', 'avata');
    if ( false === $none ) $none = __( 'Comments Off', 'avata');
 
    $number = get_comments_number( $id );
 
    $str = '';
 
    if ( 0 == $number && !comments_open() && !pings_open() ) {
        $str = '<span' . ((!empty($avata_css_class)) ? ' class="' . esc_attr( $avata_css_class ) . '"' : '') . '>' . $none . '</span>';
        return $str;
    }
	
 
    if ( post_password_required() ) {
     
        return '';
    }
 
    $str = '<a href="';
    if ( $wpcommentsjavascript ) {
        if ( empty( $wpcommentspopupfile ) )
            $home = home_url();
        else
            $home = get_option('siteurl');
        $str .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
        $str .= '" onclick="wpopen(this.href); return false"';
    } else {
        if ( 0 == $number )
            $str .= get_permalink() . '#respond';
        else
            $str .= get_comments_link();
        $str .= '"';
    }
 
    if ( !empty( $avata_css_class ) ) {
        $str .= ' class="'.$avata_css_class.'" ';
    }
    $title = the_title_attribute( array('echo' => 0 ) );
 
    $str .= apply_filters( 'comments_popup_link_attributes', '' );
 
    $str .= ' title="' . esc_attr( sprintf( __('Comment on %s', 'avata'), $title ) ) . '">';
    $str .= avata_get_comments_number_str( $zero, $one, $more );
    $str .= '</a>';
     
    return $str;
}

/**
 * Modifies WordPress's built-in comments_number() function to return string instead of echo
 */
function avata_get_comments_number_str( $zero = false, $one = false, $more = false, $deprecated = '' ) {
    if ( !empty( $deprecated ) )
        _deprecated_argument( __FUNCTION__, '1.3' );
 
    $number = get_comments_number();
 
    if ( $number > 1 )
        $output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comments', 'avata') : $more);
    elseif ( $number == 0 )
        $output = ( false === $zero ) ? __('No Comments', 'avata') : $zero;
    else // must be one
        $output = ( false === $one ) ? __('1 Comment', 'avata') : $one;
 
    return apply_filters('comments_number', $output, $number);
}


// get summary

 function avata_get_summary(){
	 
	 $excerpt_or_content        = avata_option('excerpt_or_content','excerpt');
	 $excerpt_length            = avata_option('excerpt_length');
	 if( $excerpt_or_content == 'full_content' ){
	 $output = get_the_content();
	 }
	 else{
	 $output = get_the_excerpt();
	 if( is_numeric($excerpt_length) && $excerpt_length !=0  )
	 $output = avata_content_length($output, $excerpt_length );
	 }
	 return  $output;
	 }
	 
 function avata_content_length($content, $limit) {
    $excerpt = explode(' ', trim($content), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
    }