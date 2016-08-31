<?php get_header(); ?>


<div id="container2" class="bdr bdr-top">

<div class="content left two-thirds">
<h2 class="thisMonth embossed" style="color:#fff;">This Month:</h2>


<article class="post">
<?php if (have_posts()) :?>
<?php while (have_posts()) : the_post();?>

<h2 class=""><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
<?php the_title();?> </a></h2>


<div class="entry-content"><!--//post-->
<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail('large');
			} ?>
<p><?php the_content();?></p>
<p class="left"><a class="more" href="<?php the_permalink()?>">Read more &raquo;</a></p>

</div><!--//.entry-content-->

<p class="left"><a class="more" href="#">Read more &raquo;</a></p>
<p class="right"><a class="comments" href="<?php the_permalink() ?>"><?php comments_number('0', '1', '%') ?></a></p>
<p class="entry-meta">by <?php the_author_meta('first_name'); ?>
<?php the_author_meta('display_name'); ?> in <?php the_category(", ");?></p>


<div class="push"></div>
</article>

<?php endwhile; ?>
<?php else : ?>
<h2 class="center">Not Found</h2>
<p class="center">Sorry, but you are looking for something that isn't here.</p>
<?php get_search_form(); ?>
<?php endif; ?>



<div class="push"></div>
</div><!--content-->


<!-- #left sidebar -->
<?php get_sidebar(); ?>
<!--//.sidebar1  -->


<div class="push"></div>

</div><!--//#container2-->



</div><!--//#container-->
<div id="across">
<?php get_footer(); ?>
