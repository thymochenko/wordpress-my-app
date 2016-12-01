<?php get_header(); ?>
<?php ad_mag_lite_get_breadcrumb(); ?>
<!--/end .breadcrumb-->

<div id="main-content" class="mb-20">

    <div class="wrapper">

        <div class="row">
            <?php if(is_active_sidebar( 'right-sidebar' )) {
                echo '<div class="kopa-main-col">';
            }else {
                echo '<div class="col-md-12 col-sm-12 col-xs-12">';
            }
            ?>
            <div class="widget kopa-masonry-6-widget">
                <ul class="kopa-masonry-wrap">
                   <?php if(have_posts()) : while(have_posts()) : the_post(); $icon = get_post_format(); 
                   if(is_sticky(get_the_id())){
                    $sticky = 'sticky-post ';
                }else{
                    $sticky = '';
                }

                if($icon){
                    $post_class = $sticky.'entry-item '.$icon.'-post';
                }else{
                    $post_class = $sticky.'entry-item';
                } 

                if(!has_post_thumbnail()){
                    $post_class .= ' no-thumb';
                }

                ?>
                <li class="ms-item6">
                    <article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
                        <div class="pd-20">
                           <?php if(has_post_thumbnail()) : ?>
                           <div class="entry-thumb style1">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                              <?php the_post_thumbnail( 'ad-mag-lite-article-list-blog-375x190' ); ?>
                           </a>
                           <?php ad_mag_lite_the_first_category(get_the_id()); ?>
                           <a class="thumb-icon style1" href="<?php the_permalink(); ?>"></a>
                           <span class="sticky-icon"></span>
                       </div>
                   <?php endif; ?>
                   <div class="entry-content">
                    <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event">
                        <a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <?php if(is_sticky()) : ?>
                        <span class="sticky-span fa fa-bolt"></span>
                    <?php endif; ?>
                </h4>
                <div class="entry-meta">
                    <?php ad_mag_lite_author_avatar(get_the_author_meta('ID'), true); ?>
                    &nbsp;|&nbsp;
                    <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                </div>
                <?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'ad-mag-lite' ); ?></a>
            </div>
        </div>      
    </article>
</li>
<?php endwhile; else : ?>
 <p><?php _e( 'Sorry, no posts matched your criteria.', 'ad-mag-lite' ); ?></p>
<?php endif; ?>
</ul>

<?php get_template_part('module/template','pagination' ); ?>

</div>
<!-- widget --> 

</div>
<!-- kopa-main-col -->

<?php if(is_active_sidebar( 'right-sidebar' )) {
    echo '<div class="sidebar">';
    dynamic_sidebar( 'right-sidebar' );
    echo '</div>';
} 
?>

</div>
<!-- row --> 

</div>
<!-- wrapper -->

</div>
<!-- main-content -->
<?php get_footer(); ?>