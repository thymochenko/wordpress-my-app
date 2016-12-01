<?php
$gal_ids = ad_mag_lite_content_get_gallery_attachment_ids(get_the_content());
if ( !empty($gal_ids) ):
?>
<div class="entry-thumb">
    <div class="owl-carousel owl-carousel-7">
        <?php foreach ($gal_ids as $ids) : ?>
        <div class="item">
            <a href = <?php the_permalink(); ?>> <?php  echo wp_get_attachment_image( $ids, 'ad-mag-lite-post-thumb');?></a>
        </div>
        <!-- item -->
        <?php endforeach; ?>
        
    </div>
    <!-- owl-carousel-7 -->
</div>
<?php else: ?>
    <a href = "<?php the_permalink(); ?>"><?php the_post_thumbnail('ad-mag-lite-post-thumb', array('title' => get_the_title(), 'class' => 'img-responsive')); ?></a>
<?php endif; ?>