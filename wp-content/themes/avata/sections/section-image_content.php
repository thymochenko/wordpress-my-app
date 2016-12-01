<?php
 $enable       = avata_option('section_image_content_enable');
 $post_id      = absint(avata_option('section_image_content_page'));
 $section_id   = esc_attr(sanitize_title(avata_option('section_image_content_id')));
 $bottom_image = avata_option('section_image_content_bottom_image');
 
 $img_class = '';
 if( $bottom_image == '1')
 $img_class = 'bottom-image';
?>
<?php if( $enable == '1' ):?>
<div class="section section-image_content" id="<?php echo $section_id; ?>">
  <div class="container">
    <div class="row">
    <?php
	  if( $post_id  > 0 ):
	  $query = new WP_Query( array( 'page_id' => $post_id ) );
	  if ( $query->have_posts() ) :
		  while ( $query->have_posts() ) :
			  $query->the_post();
	  ?>
      <div class="col-md-7 content-image-image">
          <?php
		if( has_post_thumbnail()  ){
			the_post_thumbnail();
		}
		?>
      </div>
      
      <div class="col-md-5 content-image-content">
        <h2 class="heading-lite"><?php the_title();?></h2>
        <div class="section-content"><?php the_content();?></div>
         </div>
      
      <?php
	  endwhile;
	   wp_reset_postdata();
	  endif;
	   endif;
	  ?>
    </div>
  </div>
</div>
<?php endif;