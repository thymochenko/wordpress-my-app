<?php
 $enable       = avata_option('section_features_enable');
 $post_id    = absint(avata_option('section_features_page'));
 $section_id = esc_attr(sanitize_title(avata_option('section_features_id')));

?>
<?php if( $enable == '1' ):?>
<section class="section section-features" id="<?php echo $section_id; ?>">
      <div class="container">
        <div class="row">
          <div class="col-md-5">
            <div class="section-features-desc">
            <?php
	  if( $post_id  > 0 ):
	  $query = new WP_Query( array( 'page_id' => $post_id ) );
	  if ( $query->have_posts() ) :
		  while ( $query->have_posts() ) :
			  $query->the_post();
	  ?>
              <h2 class="heading-lite"><?php the_title();?></h2>
              <?php the_content();?>
     <?php
	  endwhile;
	   wp_reset_postdata();
	  endif;
	   endif;
	  ?>
            </div>
          </div>
          <div class="col-md-6">
            <ul class="iconlist">
              <?php 
	  
	  for( $j=0;$j<6;$j++):
	                                            
	  $feature_icon    =  esc_attr(avata_option('section_features_icon_'.$j));
	  $feature_icon    =  str_replace('fa-','',$feature_icon );
	  $feature_image   =  esc_url(avata_option('section_features_image_'.$j));
	  $page            =  absint(avata_option('section_features_page_'.$j));
	  $link            =  esc_attr(avata_option('section_features_link_'.$j));
	  $target          =  esc_attr(avata_option('section_features_target_'.$j));
	  
	  if( $page > 0):
	  $query2 = new WP_Query( array( 'page_id' => $page ) );
	  
	    if ( $query2->have_posts() ) :
		  while ( $query2->have_posts() ) :
	   $query2->the_post();
			  
	  if( $link != "1" )
	  $title = get_the_title();
	  else
	  $title = '<a href="'.esc_url( get_permalink() ).'" target="'.$target.'">'.get_the_title().'</a>';
	  
	  $icon            = '';
	  if( $feature_image !='' )
	  $icon  = '<img class="feature-box-icon"  src="'.$feature_image.'" alt="" />';
	  else
	  $icon  = '<i class="feature-box-icon fa fa-'.$feature_icon.'"></i>';
	  
	   
	
			  
		echo '<li> <span class="iconlist_icon">'.$icon.'</span>
                <h3>'.$title.'</h3>
                <p>'. get_the_excerpt().'</p>
              </li>';
			  
      endwhile;
	   wp_reset_postdata();
	  endif;
	  endif;
	  endfor;
	  ?>
            </ul>
          </div>
        </div>
      </div>
    </section>
<?php endif;