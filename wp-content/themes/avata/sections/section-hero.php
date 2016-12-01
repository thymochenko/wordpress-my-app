<?php
 $enable       = avata_option('section_hero_enable');
 $mode         = avata_option('section_hero_content_mode');
 $custom_page  = avata_option('section_hero_custom');
 $post_id      = avata_option('section_hero_page');
 $section_id   = avata_option('section_hero_id');
 $bottom_image = avata_option('section_hero_bottom_img');
 
 
 $img_class = '';
 if( $bottom_image == '1')
 $img_class = 'bottom-image';
?>
<?php if( $enable == '1' ):?>

<section class="section section-hero" id="<?php echo $section_id; ?>">
<?php if( $mode == '1' ):?>
<?php
  $query = new WP_Query( array( 'page_id' => $custom_page ) );
  if ( $query->have_posts() ) :
  while ( $query->have_posts() ) :
  $query->the_post();
  the_content();
  endwhile;
  wp_reset_postdata();
  endif;
?>
      
<?php else:?>
<div class="container">
      <?php
	   if( $post_id  > 0 ):
	  $query = new WP_Query( array( 'page_id' => $post_id ) );
	  if ( $query->have_posts() ) :
		  while ( $query->have_posts() ) :
			  $query->the_post();
	  ?>
      <div class="row">
       <div class="col-md-6">
        <div class="hero_wrap">
       
          <div class="hero_content">
            <h2 class="hero_title"><?php the_title();?></h2>
            <div class="hero_subtitle"><?php the_excerpt();?></div>
          </div>
          </div>
        </div>
        <div class="col-md-6">
        
        <div class="hero_image <?php echo $img_class; ?>">
        <?php
		if( has_post_thumbnail()  ){
			the_post_thumbnail();
		}
		?>
        </div>  

        </div>      
      </div>
      <?php
	  endwhile;
	   wp_reset_postdata();
	  endif;
	  endif;
	  ?>
      </div>
<?php endif; ?>
    </section>
<?php endif;