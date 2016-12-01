<?php
 $enable       = avata_option('section_content_image_enable');
 $post_id    = absint(avata_option('section_content_image_page'));
 $section_id = esc_attr(sanitize_title(avata_option('section_content_image_id')));
 $bottom_image = avata_option('section_content_image_bottom_image');
 
 $img_class = '';
 if( $bottom_image == '1')
 $img_class = 'bottom-image';
?>
<?php if( $enable == '1' ):?>
<section class="section section-content_image" id="<?php echo $section_id; ?>">
    <div class="container">
        <div class="row">
<?php
	  if( $post_id  > 0 ):
	  $query = new WP_Query( array( 'page_id' => $post_id ) );
	  if ( $query->have_posts() ) :
		  while ( $query->have_posts() ) :
			  $query->the_post();
	  ?>
            <div class="col-sm-7 content-image-content">
                <h2 class="heading-lite"><?php the_title();?></h2>
                <div class="section-content"><?php the_content();?></div>
            </div>
            <div class="col-sm-5 content-image-image <?php echo $img_class; ?>">
               <?php
		if( has_post_thumbnail()  ){
			the_post_thumbnail();
		}
		?>
            </div>
 <?php
	  endwhile;
	   wp_reset_postdata();
	  endif;
	   endif;
	  ?>
        </div>
    </div>
</section>
<?php endif;