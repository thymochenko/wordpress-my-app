<?php
/**
 * The template for displaying all WooCommerce pages.
 *
 * @package shopbiz
 */
get_header(); ?>


</header> <!-- / END HOME SECTION  -->
<?php $shop_image = get_theme_mod('shop_image',get_template_directory_uri() . '/images/breadcrumb/background.jpg'); 
	  $shopbiz_overlay_shop_color_control = get_theme_mod('shopbiz_overlay_shop_color_control','');
?>
<div class="ta-breadcrumb-section" style="background:url(<?php echo esc_url($shop_image);?>)" >
  <div class="overlay"  style="background-color:<?php echo esc_html($shopbiz_overlay_shop_color_control);?>"> 
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="ta-breadcrumb-title">
            <h1>
              <?php the_title(); ?>
            </h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php  
$woo_layout= get_theme_mod('woo_layout','sidebar_off');
?>
<main id="content">
    <div class="container">
		<div class="row">
		<?php
			if(is_single())
		{ ?>
		<div class="col-md-12">
		<?php }
		elseif($woo_layout == 'sidebar_off')
		{?>
		<div class="col-md-12">	
		<?php }
		elseif($woo_layout == 'left') 
		{ 
		?>
		<aside class="col-md-3">
				<div id="sidebar-right" class="ta-sidebar">
				<?php
					dynamic_sidebar( 'sidebar-woo' );
					?>
				</div>	
		</aside>
		<div class="<?php if(is_active_sidebar('sidebar-woo')) echo "col-md-9 col-sm-8"; else echo "col-md-12";?>">
		<?php } 
		elseif($woo_layout == 'right')
		{ ?>
		<div class="<?php if(is_active_sidebar('sidebar-woo')) echo "col-md-9 col-sm-8"; else echo "col-md-12";?>">
		<?php } woocommerce_content(); 
		$woo_layout= get_theme_mod('woo_layout','sidebar_off'); 	
		if($woo_layout == 'left') 
		{ 
		echo '</div></div>';
		}
		else
		{
		echo '</div>';	
		}
		if($woo_layout == 'right') 
		{		
		?>
		<!-- #primary -->
			<aside class="col-md-3 col-sm-4">
				<div id="sidebar-right" class="ta-sidebar">
				<?php
					dynamic_sidebar( 'sidebar-woo' );
					?>
				</div>	
			</aside><!-- .content-left-wrap -->
		<?php } ?>
	</div><!-- .container -->
   </div>	
</main><!-- #main -->
<?php get_footer(); ?>