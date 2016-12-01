<?php
/**
 * Template Name: Full Width No Sidebar
 *
 */
?>

<?php get_header(); ?>
<div class="col-md-12">
	<div class="left-content" >
	<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
		<div <?php post_class('clearfix'); ?> itemscope itemtype="http://schema.org/CreativeWork">
			<div class="content-first">
			
				<?php
				if( class_exists( 'RWMB_Loader' ) )
				{
					if( rwmb_meta( 'business_press_hide_title' ) != 1 )
					{
						?>
						<div class="content-second">
							<h1 class="the-title entry-title" id="post-<?php the_ID(); ?>" itemprop="headline"><?php the_title(); ?></h1>
						</div>
						<?php
					}
				}
				else
				{
					?>
					<div class="content-second">
						<h1 class="the-title entry-title" id="post-<?php the_ID(); ?>" itemprop="headline"><?php the_title(); ?></h1>
					</div>
					<?php
				}
				?>
				
				
				<div class="content-third" itemprop="text">
				
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
					
					<?php
					wp_link_pages( array(
							'before'           => '<p class="pagelinks">' . esc_attr__( 'Pages:', 'business-press' ),
							'after'            => '</p>',
							'link_before'      => '<span class="pagelinksa">',
							'link_after'       => '</span>',
						)
					);
					?>
					
				</div>
				
			</div>
		</div>
		
		<?php comments_template(); ?> 
		
	<?php endwhile; endif; ?>
	
	</div>
</div>
<?php get_footer(); ?>