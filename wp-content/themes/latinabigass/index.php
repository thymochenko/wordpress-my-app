<?php
get_header();
$tags_images = Repository::findImageForTags();
$pornstar = Repository::findImageForCategories("pornstar");
?>
<div class="container">
	<div class="container-controll">
		<section class="title text-left"><h1 id="principalTitle"> <span class="glyphicon glyphicon-circle-arrow-up"></span> Porn Videos Trending Now</h1></section>
		<section>
		 <?php $q = new WP_Query(Repository::findByVideosForIndex());?>
		 <?php if ($q->have_posts()) :?>
	     <?php while ($q->have_posts()) : $q->the_post();?>
			<div class="box">
				<a href="<?php the_permalink(); ?>">
				<?php
			if (has_post_thumbnail()) {
					the_post_thumbnail('medium');
			} ?>
				</a>
				<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title();?></a>
			</div>
			<?php endwhile; ?>
<?php else : ?>
       <h2 class="center">Not Found</h2>
       <p class="center">Sorry, but you are looking for something that isn't here.</p>
       <?php get_search_form(); ?>
<?php endif; ?>
<!--

foreach ( $tags as $tag ) {
	$tag_link = get_tag_link( $tag->term_id );

	$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
	$html .= "{$tag->name}</a>";
}
$html .= '</div>';
echo $html;
 -->
			<div class="clearfix"><img class="img-responsive" width="380" height="330" src="http://localhost/wp-content/themes/latinabigass/img/melancia.gif">
			</div>
			<?php $q = new WP_Query(Repository::findByVideosForCategory2());?>
		 <?php if ($q->have_posts()) :?>
	     <?php while ($q->have_posts()) : $q->the_post();?>
			<div class="box">
				<a href="<?php the_permalink(); ?>">
				<?php
			if (has_post_thumbnail()) {
				the_post_thumbnail('medium');
			} ?>
				</a>
				<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title();?></a>
			</div>
			<?php endwhile; ?>
		</section>
<?php else : ?>
       <h2 class="center">Not Found</h2>
       <p class="center">Sorry, but you are looking for something that isn't here.</p>
       <?php get_search_form(); ?>
<?php endif; ?>
<section style="padding-top:30px;" class="title"><h2 id="principalTitle"><span class="glyphicon glyphicon-circle-arrow-up"></span> Porn Videos Trending Now</h2>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/LINDA22.jpg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/linda23.jpeg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/linda24.jpg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/linda25.jpg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/LINDA22.jpg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/linda23.jpeg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/linda24.jpg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/linda25.jpg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/LINDA22.jpg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/linda23.jpeg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/linda24.jpg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
<div class="box"><img width="350" height="40" class="img-responsive" src="img/linda25.jpg">Best Latina sheik big Ass now  50.451 views<b> 89%</b></div>
</section>

<section style="padding-top:30px;" class="title"><h4 id="principalTitle"><span class="glyphicon glyphicon-circle-arrow-up"></span>Tags</h4></section>
<?php foreach($tags_images as $imgtg): ?>
 <div class="box"><img width="350" height="40" class="img-responsive" src="<?php echo $imgtg["url"] ?>">
	 <a href="<?php echo $imgtg["tag_link"] ?>"><?php echo $imgtg["nome"] ?></a></div>
<?php endforeach; ?>

<section style="padding-top:30px;" class="title"><h5 id="principalTitle"><span class="glyphicon glyphicon-circle-arrow-up"></span> Porn Stars Videos</h5></section>
<?php foreach($pornstar as $v=>$pnstar): ?>
	<?php if($pnstar["thumb"]): ?>
 <div class="box"><?php echo $pnstar["thumb"] ?>
	 <a href="index.php/tag/<?php echo $pnstar["tag_slug"] ?>"><?php echo $pnstar["name"] ?></a></div>
 <?php endif; ?>
<?php endforeach; ?>

<section style="padding-top:30px;" class="title"><h5 id="principalTitle"><span class="glyphicon glyphicon-circle-arrow-up"></span> Premmium HD</h5></section>
<img class="img-responsive" src="http://localhost/wp-content/themes/latinabigass/img/bannervd.jpg">

    </div><!-- /.container -->
		<!-- /container divisor -->

		<?php get_footer(); ?>
