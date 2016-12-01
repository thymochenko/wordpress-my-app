<?php
/*
  Template Name: Front Page
 */

get_header(); 
?>
<div id="avata-home-sections">
<?php 
global $avata_homepage_sections, $avata_home_animation;
   
foreach(  $avata_homepage_sections as $k=>$v ){
get_template_part('sections/section',$k);
}
?> 
</div>
<?php get_footer(); ?>