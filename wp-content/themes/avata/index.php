<?php

get_header(); ?>

<section class="page-main" id="content">
  <div class="container">
    <div id="primary" class="content-area">
      <div class="row">
        <main id="main" class="site-main col-md-9" role="main" aria-label="<?php _e( 'Main Area', 'avata' ); ?>">
          <?php if ( have_posts() ) : ?>
          <?php /* Start the Loop */ ?>
          <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'content', get_post_format() ); ?>
          <?php endwhile; ?>
          <?php avata_paging_nav(); ?>
          <?php else : ?>
          <?php get_template_part( 'content', 'none' ); ?>
          <?php endif; ?>
        </main>
        <!-- #main -->
        <?php get_sidebar(); ?>
      </div>
    </div>
    <!-- #primary -->
  </div>
</section>
<?php get_footer(); ?>
