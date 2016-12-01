<?php get_header(); ?>
<div class="<?php if( get_theme_mod( 'business_press_blog_archive_layout', 'rights' ) == 'rights' ) { echo 'col-md-8'; } else { echo 'col-md-12'; } ?>">
	<div class="left-content" >

		<?php
		if( have_posts() )
		{
			get_template_part( 'template-parts/content', 'loop' );
		}
		else
		{
			get_template_part( 'template-parts/content', 'none' );
		}
		?>
	</div>
</div>
<?php if( get_theme_mod( 'business_press_blog_archive_layout', 'rights' ) == 'rights' ) { get_sidebar(); } ?>
<?php get_footer(); ?>
