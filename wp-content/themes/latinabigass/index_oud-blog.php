<?php get_header(); ?>
<div class="container">
	<div class="container-controll">
	<div class="row">
	     <!--container divisor -->
	<div class="col-xs-12 col-sm-6 col-md-8 blogsession">
		<?$q = new WP_Query(Repository::findByPostsForBlog());?>
		<?php if ($q->have_posts()) :?>
	<?php while ($q->have_posts()) : $q->the_post();?> 

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title();?></a></h2>
		<p class="entry-meta">by <?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?> in <?php the_category(", ") ?></p>
		<div class="entry-content"><!--//post-->
		<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail('large');
			} ?>
			<?php the_content();?>
		</div><!--//.entry-content-->

		<p class="left"><a class="more" href="<?php the_permalink(); ?>">Read more &raquo;</a></p>
		<p class="right"><a class="comments-count" href="<?php the_permalink(); ?>"><?php comments_number('0', '1', '%'); ?></a></p>
		<div class="push"></div>
		
	</article>
<?php endwhile; ?>
<?php else : ?>
       <h2 class="center">Not Found</h2>
       <p class="center">Sorry, but you are looking for something that isn't here.</p>
       <?php get_search_form(); ?>
<?php endif; ?>

		</div>
		<!-- /container divisor -->
		<?php get_sidebar(); ?>
		<?php get_footer(); ?>