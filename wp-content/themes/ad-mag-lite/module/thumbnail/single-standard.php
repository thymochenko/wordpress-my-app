<?php if(has_post_thumbnail()) : ?>
<div class="entry-thumb">
	<?php the_post_thumbnail( 'ad-mag-lite-post-thumb', array('title' => get_the_title(), 'alt' => 'img-responsive')); ?>
</div>
<?php endif; ?>