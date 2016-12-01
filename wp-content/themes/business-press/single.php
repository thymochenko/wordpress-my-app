<?php get_header(); ?>

<div class="<?php if( get_theme_mod( 'business_press_blog_single_layout', 'rights' ) == 'rights' ) { echo 'col-md-8'; } else { echo 'col-md-12'; } ?>">
	<div class="left-content" >
		
		<?php
		if( have_posts() ) : while( have_posts() ) : the_post();
		
			get_template_part( 'content', get_post_format() );
			
			
			comments_template();

			if( get_next_post_link() || get_previous_post_link() )
			{
			?>
				<div class="content-first">
					<nav>
						 <ul class="pager">
							<?php if( get_next_post_link()) { next_post_link( '<li class="previous"> %link </li>', '&larr; %title' ); } ?>
							<?php if( get_previous_post_link()) { previous_post_link( '<li class="next"> %link </li>', '%title &rarr;' ); } ?>
						 </ul>
					</nav>	
				</div>
			<?php
			}
		
		endwhile; endif;
		?>
		
	</div>
</div>
<?php if( get_theme_mod( 'business_press_blog_single_layout', 'rights' ) == 'rights' ) { get_sidebar(); } ?>
<?php get_footer(); ?>