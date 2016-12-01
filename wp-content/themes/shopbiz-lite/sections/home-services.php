<?php 
$shopbiz_service_enable = get_theme_mod('shopbiz_service_enable');
if($shopbiz_service_enable){
?>
<!--==================== SERVICE SECTION ====================-->
<section id="service" class="ta-section text-center">
  <div class="container">
    <div class="row">
      <div class="col-md-12 wow fadeInDown animated padding-bottom-50 text-center">
        <div class="ta-heading">
          <?php $shopbiz_service_title = esc_attr(get_theme_mod('shopbiz_service_title'));
					
			if( !empty($shopbiz_service_title) ):

				echo '<h3 class="ta-heading-inner">'.$shopbiz_service_title.'</h3>';

			endif; ?>
        </div>
        <?php $shopbiz_service_subtitle = esc_attr(get_theme_mod('shopbiz_service_subtitle'));

			if( !empty($shopbiz_service_subtitle) ):

				echo '<p>'.$shopbiz_service_subtitle.'</p>';

			endif; ?>
      </div>
    </div>
    <div class="row">
      <?php 
		if(is_active_sidebar( 'shopbiz_service_widget' )):
						
			dynamic_sidebar( 'shopbiz_service_widget' );
		endif;
			 ?>
    </div>
  </div>
</section>
<?php } ?>