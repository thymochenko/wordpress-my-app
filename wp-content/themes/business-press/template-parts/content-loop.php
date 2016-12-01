<?php while( have_posts() ) : the_post(); ?>
	<div <?php post_class('clearfix postsloop'); ?> itemscope itemtype="http://schema.org/CreativeWork">
		<div class="content-first">
			
			<div class="content-second">
				<h3 class="the-title" itemprop="headline"><a class="entry-title" rel="bookmark" id="post-<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" ><?php the_title(); ?></a></h3>
			</div>
			
			<div class="content-third">
				<?php business_press_entry_meta(); ?>
			
				<div class="entry-content" itemprop="text">
					<?php
					if( get_theme_mod( 'business_press_archive_post_thumbnail', '1' ) == 1 )
					{
						business_press_post_thumbnail();
					}
					?>
					<?php the_excerpt(); ?>
				</div>
					
			</div>
			
				
		</div>
	</div>
<?php endwhile; ?>

	
<?php if( get_previous_posts_link() || get_next_posts_link() ) : ?>
	<div class="content-nav-next-pre">
		<nav>
			<ul class="pager">
						
				<?php if( get_previous_posts_link() ) : ?>
					<li class="previous"><?php previous_posts_link( esc_attr__( '&larr; Newer Entries', 'business-press' ) ); ?></li>
				<?php endif; ?>
							
				<?php if( get_next_posts_link() ) : ?>
					<li class="next"><?php next_posts_link( esc_attr__( 'Older Entries &rarr;', 'business-press' ) ); ?></li>
				<?php endif; ?>
							
			</ul>
		</nav>
	</div>
<?php endif; ?>