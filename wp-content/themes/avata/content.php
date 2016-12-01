<?php

  $display_image = avata_option('archive_display_image');
  $readmore      = avata_option('display_meta_readmore');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class("blog-post"); ?> >
   <?php if ( $display_image == '1' && has_post_thumbnail() ): ?>
  <?php the_post_thumbnail(); ?>
  <?php endif; ?>
  <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
  <?php if ( 'post' == get_post_type() ) : ?>
  
  <div class="entry-meta">
    <?php avata_posted_on(); ?>
  </div>
  <!-- .entry-meta -->
  <?php endif; ?>
  <div class="entry-summary"><?php echo avata_get_summary();?></div>
  <?php if ( $readmore == '1' ): ?>
  <a href="<?php the_permalink();?>" class="read-more"><?php _e( 'Read More', 'avata' );?> ...<span class="screen-reader-text"><?php the_title();?></span></a> 
  <?php endif; ?>
</article>