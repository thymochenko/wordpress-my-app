<?php
$content = get_the_content();
$open_tags  = '<blockquote>';
$close_tags = '</blockquote>';
$temp = strstr($content, $open_tags);
$result = strstr($temp, $close_tags, true).$close_tags;
if (!empty($result)) {
	printf($result);
} elseif(has_post_thumbnail()){
	the_post_thumbnail('ad-mag-lite-post-thumb', array('title' => get_the_title(), 'class' => 'img-responsive'));
}