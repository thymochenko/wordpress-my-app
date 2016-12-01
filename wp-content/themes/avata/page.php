<?php
get_header(); 

$main_class = 'no-aside';

?>

<section class="page-main" id="content">
  <div class="container">
    <div id="primary" class="content-area row <?php echo $main_class;?>">
        <main id="main" class="site-main col-main" role="main" aria-label="<?php _e( 'Main Area', 'avata' ); ?>">
          <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'content', 'page' ); ?>
          <?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>
          <?php endwhile; // end of the loop. ?>
        </main>
       
</div>
      <!-- #primary -->
    
  </div>
</section>
<?php get_footer(); ?>
