<?php get_header(); ?>
<div class="container">


	<div class="container-controll">
	<div class="row">
	     <!--container divisor -->
		<div class="col-xs-12 col-sm-6 col-md-8 blogsession">
			<h1>Single:</h1>
		<?php custom_breadcrumbs(); ?>
		<?php $isVideoCat = false;$count=0; if (have_posts()) :?>
	<?php while (have_posts()) : the_post();?>
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title();?></a></h2>
		<p class="entry-meta">by <?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?> in <?php the_category(", ") ?> | comments (<?php comments_number('0', '1', '%'); ?>)</p>

		<div class="entry-content"><!--//post-->
			<?php if (has_post_thumbnail()) { ?>
			 <?php $cat =  get_the_category();?>
				<?php if($cat[$count]->name != "video"){
					the_post_thumbnail('medium');
				}
				else{
					$isVideoCat = true;
				}
			 }  ?>
			<?php the_content();?>

		</div><!--//.entry-content-->
		<div class="tags">
			<?php the_tags( 'Tags: ', ', ', '<br />' );?>
		</div>
		<div id="bannersubvideo">
			<a href="http://localhost/api/apiv1/web/index.php/banners/plugrush/abaixo_video_player"><img src="http://cdn11.contentabc.com/ads/bz_650x65_568341/568341_9391ae3a69c505a1f9fd861705d9a5de.jpg"></a></div>
		<br>
		<br>
		 	<?php $relatedPosts = Repository::findRelatedCategoryPosts(get_the_ID());?>
			<h4>Related Posts</h4>
			<?php if( $relatedPosts->have_posts() ) {
			while ($relatedPosts->have_posts()) : $relatedPosts->the_post(); ?>
			<div class="box">
				<a href="<?php the_permalink(); ?>">
				<?php
			if (has_post_thumbnail()) {
				the_post_thumbnail('medium');
			} ?>
				</a>
				<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title();?></a>
			</div>
			<?php
			endwhile;
		}
		?>
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
