<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<?php

$header_class   = '';
if( is_page_template('template-frontpage.php') )
$header_class   = 'header-overlay';

$header_image = get_header_image();
?>
<body <?php body_class(); ?> >

<header id="header" class="<?php echo $header_class; ?>" role="banner" aria-label="<?php _e( 'Header', 'avata' ); ?>">
<a class="skip-link screen-reader-text" href="#content">
	<?php esc_html_e( 'Skip to content', 'avata' ); ?>
</a><!-- .skip-link -->

<div class="top-wrap">
  <?php if( $header_image ):?>
  <img src="<?php echo esc_url($header_image); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
  <?php endif;?>
</div>

  <div class="container">
    <div class="logo-box">
      <?php
	  the_custom_logo();
     
	  ?>
      <div class="name-box">
      <?php if ( is_front_page() || is_home() ) :?>
      <h1 class="site-name"><a href="<?php echo esc_url(home_url('/')); ?>">
       
          <?php bloginfo('name'); ?>
       
        </a></h1>
        <?php else : ?>
		<span class="site-name">
			<a href= "<?php echo esc_url( home_url( '/' ) );?>" rel="home"><?php bloginfo( 'name' );?></a>
		</span>
	<?php endif;?>
        
        <span class="site-tagline">
        <?php bloginfo('description'); ?>
        </span> </div>
    </div>
    
    <nav id="menu" class="site-nav" role="navigation" aria-label='<?php _e( 'Primary Menu ', 'avata' ); ?>'>
    <h2 class="screen-reader-text"><?php _e( 'Primary Menu', 'avata' ); ?></h2>
      <?php 
	             
 wp_nav_menu(array('theme_location'=>'primary','depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span class="menu-item-label">', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
 ?>
    </nav>
  </div>
</header>