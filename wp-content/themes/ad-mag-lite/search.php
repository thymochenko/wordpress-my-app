<?php 
get_header(); 

$layout = get_theme_mod('blog-layout', '1');
get_template_part('module/blog', $layout);

get_footer(); 