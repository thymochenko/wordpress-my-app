<?php 
	$shopbiz_news_enable = get_theme_mod('shopbiz_news_enable');
	if($shopbiz_news_enable){
	$shopbiz_total_posts = get_option('posts_per_page'); /* number of latest posts to show */
	
	if( !empty($shopbiz_total_posts) && ($shopbiz_total_posts > 0) ):

    $news_background = get_theme_mod('news_background','');
    $news_section_color = get_theme_mod('news_section_color','');
	
	?>
<!--==================== BLOG SECTION ====================-->
<?php if($news_background != '') { ?>

<section id="blog" class="ta-blog-section" style="background-image:url('<?php echo esc_url($news_background);?>');">
<?php } else { ?>
<section id="blog" class="ta-blog-section">
  <?php } ?>
  <div class="overlay" style="background-color:<?php echo esc_html($news_section_color);?>">
    <div class="container">
      <div class="row">
        <div class="col-md-12 wow fadeInDown animated padding-bottom-50 text-center">
          <div class="ta-heading">
            <?php
            $shopbiz_news_title = esc_attr(get_theme_mod('shopbiz_news_title'));
          
            if( !empty($shopbiz_news_title) ):
              echo '<h3 class="ta-heading-inner">'.$shopbiz_news_title.'</h3>';
            endif;
             ?>
          </div>
          <?php  $shopbiz_news_subtitle = esc_attr(get_theme_mod('shopbiz_news_subtitle'));

            if( !empty($shopbiz_news_subtitle) ):

              echo '<p>'.$shopbiz_news_subtitle.'</p>';

          endif; ?>
        </div>
      </div>
      <div class="clear"></div>
	  <div class="row">
      <?php 
	  
	  $news_select = get_theme_mod('news_select',3);
	  $shopbiz_latest_loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => $news_select, 'order' => 'DESC','ignore_sticky_posts' => true ) );
						
			$newSlideActive = '';
			$newSlide 		= '';
			$newSlideClose 	= '';
			$i_latest_posts= 0;
						
			if ( $shopbiz_latest_loop->have_posts() ) :
						
				while ( $shopbiz_latest_loop->have_posts() ) : $shopbiz_latest_loop->the_post();
					
					$i_latest_posts++;

						if ( !wp_is_mobile() ){

							if($i_latest_posts == 1){
								echo $newSlideActive;
							}
							else if($i_latest_posts % 4 == 1){
								echo $newSlide;
							} ?>
      
			  <div class="col-md-4 wow pulse animated">
		        <div class="ta-blog-post-box"> 
		        	<a class="ta-blog-thumb" href="<?php echo get_permalink() ?>" title="<?php echo get_the_title() ?>">

		            	<?php if ( has_post_thumbnail() ) :
							the_post_thumbnail();
						else:
						echo '<img src="'.esc_url( get_template_directory_uri() ).'/images/blog/blog-thumbs.jpg" class="img-responsive" alt="'.get_the_title().'" />';
					    endif; ?>

			          	<span class="ta-blog-date">
			          		<span class="h3"><?php echo get_the_date('j'); ?></span>
			          		<span><?php echo get_the_date('M'); ?></span> 
			          	</span> 
		          	</a>
		          	<article class="small">
			            <h2>
			            	<a href="<?php echo get_permalink() ?>" title="<?php echo get_the_title() ?>"><?php echo get_the_title() ?></a>
			            </h2>
			            <div class="ta-blog-category"> 
			            	<i class="fa fa-folder"></i>&nbsp; 
			              		<?php $cat_list = get_the_category_list();
								if(!empty($cat_list)) { ?>
			              		<?php the_category(', '); ?>
			              	
			              <?php } ?>
			              	<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>">
			              		<i class="fa fa-user"></i>&nbsp;by <?php the_author(); ?>
			              	</a> 
			            </div>
			            <?php the_excerpt(); ?>
		          	</article>
		        </div>
		      </div>
		<?php } endwhile; endif;	wp_reset_postdata(); ?>
	
    </div>
    <!-- .container --> 
  </div>
 </div> 
</section>
<?php endif; }?>