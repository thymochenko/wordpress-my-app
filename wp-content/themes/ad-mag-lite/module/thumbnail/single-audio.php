<?php

$audio = ad_mag_lite_content_get_audio( get_the_content());
$displayed_video = false;
if ( isset( $audio[0] ) ) {
    $audio = $audio[0];
    if ( isset( $audio['shortcode'] ) ){
        echo do_shortcode( $audio['shortcode'] );
        $displayed_audio = true;
    }
} elseif(has_post_thumbnail()){
    the_post_thumbnail('ad-mag-lite-post-thumb', array('title' => get_the_title(), 'class' => 'img-responsive'));
}



