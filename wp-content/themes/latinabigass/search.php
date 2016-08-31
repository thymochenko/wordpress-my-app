<?php get_header(); ?>
<div class="container">
	<div class="container-controll">
	<div class="row">
	     <!--container divisor -->
		<div class="col-xs-12 col-sm-6 col-md-8 blogsession">
	<?php $isVideoCat = false;$count=0; if (have_posts()) :?>
	<?php while (have_posts()) : the_post();?> 
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title();?></a></h2>
		<p class="entry-meta">by <?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?> in <?php the_category(", ") ?> | comments (<?php comments_number('0', '1', '%'); ?>)</p>

		<div class="entry-content"><!--//post-->
			<?php if (has_post_thumbnail()) { ?>
			 <?php $cat =  get_the_category();
			  $category = strpos($cat[$count]->name, "video");
			 ?>
				<?php if($category === false){
					the_post_thumbnail('medium');
				}
				else{
					$isVideoCat = true;
				}
			 }  ?>
			<?php the_content();?>
		</div><!--//.entry-content-->
	
		<div class="push"><?php comments_template(); ?> </div>
		
	</article>
<?php $count++; endwhile; ?>
<?php else : ?>
       <h2 class="center">Not Found</h2>
       <p class="center">Sorry, but you are looking for something that isn't here.</p>
       <?php get_search_form(); ?>
<?php endif; ?>

		</div>
		<!-- /container divisor -->
		<?php get_sidebar(); ?>
		<?php get_footer(); ?>