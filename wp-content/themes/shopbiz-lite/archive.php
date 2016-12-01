<?php
/**
 * The template for displaying archive pages.
 *
 * @package shopbiz
 */

get_header(); ?>
  
<!-- Breadcrumb -->
<div class="ta-breadcrumb-section">
  <div class="overlay">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="ta-breadcrumb-title">
            <h1>
				<?php 
				if ( is_category() ) : ?>
				<h1><?php echo single_cat_title("", false); ?></h1>
				<?php elseif ( is_tag() ) : ?>
				<h1><?php printf( __( 'Tag Archives: %s', 'shopbiz' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
				<?php elseif ( is_author() ) : ?>
				<h1><?php echo single_cat_title("", false); ?></h1>
				<?php elseif ( is_day() ) : ?>
				<?php  _e( "Daily Archives:", 'shopbiz' ); echo esc_attr((get_the_date())); ?>
				<?php elseif ( is_month() ) : ?>
				<?php  _e( "Monthly Archives:", 'shopbiz' ); echo esc_attr((get_the_date( 'F Y' ))); ?>
				<?php elseif ( is_year() ) : ?>
				<?php  _e( "Yearly Archives:", 'shopbiz' );  echo esc_attr((get_the_date( 'Y' ))); ?>
				<?php else : ?>
				<?php _e( "Blog Archives", 'shopbiz' ); ?>
				<?php endif; ?>	
				<?php if(get_post_meta( get_the_ID(), 'post_description', true ) != '' ) { ?>
				<p><?php echo get_post_meta( get_the_ID(), 'post_description', true ) ; ?></p>
				<?php } ?>
            </h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /End Breadcrumb -->
<main id="content">
  <div class="container">
    <div class="row">
      <div class="<?php echo ( !is_active_sidebar( 'sidebar_primary' ) ? '12' :'9' ); ?> col-md-9">
			<?php 
			if( have_posts() ) :
			while( have_posts() ): the_post();
			get_template_part('content',''); 
			endwhile; endif;
			get_template_part('content','');
			?>
          <div class="col-md-12 text-center">
			<?php
			//Previous / next page navigation
			the_posts_pagination( array(
			'prev_text'          => __( '<i class="fa fa-long-arrow-left"></i>', 'shopbiz' ),
			'next_text'          => __( '<i class="fa fa-long-arrow-right"></i>', 'shopbiz' ),
			) );
			?>
          </div>
      </div>
	  <aside class="col-md-3">
        <?php get_sidebar(); ?>
      </aside>
    </div>
  </div>
</main>
<?php get_footer(); ?>