<?php
$video = ad_mag_lite_content_get_video( get_the_content());
$displayed_video = false;
if ( isset( $video[0] ) ) {
	$video = $video[0];
	if ( isset( $video['shortcode'] ) ) {
		echo do_shortcode( $video['shortcode'] );
		$displayed_video = true;
	}
} elseif (has_post_thumbnail()){
	the_post_thumbnail('ad-mag-lite-post-thumb', array('title' => get_the_title(), 'class' => ''));
}
