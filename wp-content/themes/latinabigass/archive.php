<?php get_header(); ?>
<div class="container">
	<h1>Archive</h1>
	<div class="container-controll">
	<div class="row">
	    <div class="col-xs-12 col-sm-6 col-md-8 blogsession">
		<?php $isVideoCat = false;$count=0; if (have_posts()) :?>
			<?php while (have_posts()) : the_post();?>
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title();?></a></h2>
		<p class="entry-meta">by <?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?> in <?php the_category(", ") ?></p>

		<div class="entry-content"><!--//post-->
			<?php the_content();?>
		</div><!--//.entry-content-->

		<div class="push"></div>

	</article>
<?php ++$count; endwhile; ?>

<div style="float:left" class="nav-previous alignleft"><h4><?php next_posts_link( 'Older posts' ); ?></h4></div>
<div style="float:right" class="nav-next alignright"><h4><?php previous_posts_link( 'Newer posts' ); ?></h4></div>

<?php else : ?>
       <h2 class="center">Not Found</h2>
       <p class="center">Sorry, but you are looking for something that isn't here.</p>
       <?php get_search_form(); ?>
<?php endif; ?>

		</div>
		<!-- /container divisor -->
		<?php get_sidebar(); ?>
		<?php get_footer(); ?>
