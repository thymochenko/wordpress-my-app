<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package shopbiz
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >
<div class="wrapper">
<a style="display:none;" class="skip-link screen-reader-text" href="#content">
<?php esc_html_e( 'Skip to content', 'shopbiz' ); ?>
</a>
<header> 
  <!--==================== Header ====================-->
  <div class="ta-main-nav">
    <nav class="navbar navbar-default navbar-wp">
      <div class="container">
        <div class="navbar-header"> 
			<!-- Logo -->
			<?php
			if(has_custom_logo())
			{
			// Display the Custom Logo
			the_custom_logo();
			}
			 else { ?>
			<a class="navbar-brand" href="<?php echo home_url( '/' ); ?>"><?php bloginfo('name'); ?><br>
      <span class="site-description"><?php echo  get_bloginfo( 'description', 'display' ); ?></span>   
      </a>			
			<?php } ?>
			</h1>
          <!-- navbar-toggle -->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="fa fa-ellipsis-v fa-lg"></span> </button>
        </div>
        <!-- /navbar-toggle --> 
        
        <!-- Navigation -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-right', 'fallback_cb' => 'shopbiz_custom_navwalker::fallback' , 'walker' => new shopbiz_custom_navwalker() ) ); ?>
        </div>
        <!-- /Navigation --> 
      </div>
    </nav>
  </div>
</header>
<!-- #masthead --> 