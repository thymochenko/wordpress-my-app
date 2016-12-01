<?php
if( !function_exists( 'business_press_inline_css' ) )
{
	function business_press_inline_css()
	{
			$business_press_product_per_column = absint( get_theme_mod( 'business_press_product_per_column', '4' ) );
			
			//if fail, do default
			$business_press_custom_css = "
				.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {
					width: 22%;
					}
					";
			
			if( $business_press_product_per_column == 2 )
			{
				$business_press_custom_css = "
				.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {
					width: 46%;
					}
					";
			}
			
			if( $business_press_product_per_column == 3 )
			{
				$business_press_custom_css = "
				.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {
					width: 30%;
					}
					";
			}
			
			if( $business_press_product_per_column == 4 )
			{
				$business_press_custom_css = "
				.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {
					width: 22%;
					}
					";
			}
			
			if( $business_press_product_per_column == 5 )
			{
				$business_press_custom_css = "
				.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {
					width: 16.9%;
					}
					";
			}
	
			wp_add_inline_style( 'business-press-style-core', $business_press_custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'business_press_inline_css' );
?>