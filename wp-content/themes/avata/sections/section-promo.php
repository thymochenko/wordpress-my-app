<?php
 $enable       = avata_option('section_promo_enable');
 $allowedposttags = wp_kses_allowed_html( 'post' );
 $section_id      = esc_attr(sanitize_title(avata_option('section_promo_id')));
 $promo_info      = wp_kses(avata_option('section_promo_info'), $allowedposttags);
 
 $btn_text_1      = esc_attr(avata_option('section_promo_btn_text_1'));
 $btn_link_1      = esc_url(avata_option('section_promo_btn_link_1'));
 $btn_target_1    = esc_attr(avata_option('section_promo_btn_target_1'));
 $btn_text_2      = esc_attr(avata_option('section_promo_btn_text_2'));
 $btn_link_2      = esc_url(avata_option('section_promo_btn_link_2'));
 $btn_target_2    = esc_attr(avata_option('section_promo_btn_target_2'));
?>
<?php if( $enable == '1' ):?>
<section class="section section-promo" id="<?php echo $section_id; ?>">
    <div class="container">
        <div class="promo-box">
         <div class="promo-info">
	       <?php echo do_shortcode($promo_info );?>
	        </div>
<div class="promo-action">
 <?php if( $btn_text_1 != '') :?>
 <a class="btn btn-lg promo-btn-1" href="<?php echo $btn_link_1; ?>" target="<?php echo $btn_target_1; ?>"><?php echo do_shortcode($btn_text_1 );?></a>
 <?php endif;?>
 <?php if( $btn_text_2 != '') :?>
 <a class="btn btn-lg btn-bordered promo-btn-2" href="<?php echo $btn_link_2; ?>" target="<?php echo $btn_target_2; ?>"><?php echo do_shortcode($btn_text_2 );?></a>
 <?php endif;?>
	        </div>
		</div>
    </div>
</section>
<?php endif;