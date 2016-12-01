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
            <div class="kopa-bg-content">
                <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                <?php
                $post_format = get_post_format();
                $post_format = ($post_format == false) ? 'standard' : $post_format;
                ?>
                <div class="pd-20 kopa-entry-post">

                    <article class="entry-item">
                        <p class="entry-categories style-s">
                           <?php the_category( ' ' ); ?>
                       </p>
                       <?php $title = get_the_title(); ?>
                       <?php if(!empty($title)) : ?>
                       <h4 class="entry-title"><?php the_title(); ?></h4>
                   <?php endif; ?>
                   <div class="entry-meta mb-20">
                    <?php ad_mag_lite_author_avatar(get_the_author_meta('ID'), true); ?>
                    &nbsp;|&nbsp;
                        <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                    </div>
                    <?php get_template_part( 'module/thumbnail/single', $post_format); ?> 
            <?php 
            $content = get_the_content(); 
            switch ($post_format) {
                case 'quote':
                $open_tags = '<blockquote>';
                $close_tags = '</blockquote>';
                $temp = strstr($content, $open_tags);
                $key = strstr($temp, $close_tags, true).$close_tags;
                $content = str_replace($key, '', $content);
                break;
                case 'video':
                $content = preg_replace("/\[youtube.*].*\[\/youtube]/", "", $content);
                $content = preg_replace('/\[vimeo.*].*\[\/vimeo]/', '', $content);
                $content = preg_replace('/\[video.*](.*\[\/video]){0,1}/', '', $content);
                $content = apply_filters( 'the_content', $content );
                $content = str_replace(']]>', ']]&gt;', $content);
                break;
                case 'audio' :
                $content = preg_replace( '/\[audio.*](.*\[\/audio]){0,1}/', '', $content );
                $content = preg_replace( '/\[soundcloud.*].*\[\/soundcloud]/', '', $content );
                $content = apply_filters( 'the_content', $content );
                $content = str_replace(']]>', ']]&gt;', $content);
                $content = str_replace('<p>&nbsp;</p>', '', $content);
                break;
                default:
                $content = apply_filters( 'the_content', $content );
            }
            echo wp_kses_post( $content );
            ?>

</article> 

<div class="page-navigation">
    <?php 
    get_template_part( 'module/template', 'page-navigation' );
    ?>
</div> 

<?php if(has_tag()) : ?>
    <div class="kopa-tag-box">
        <?php the_tags( '<span>'.esc_html__( 'Tags', 'ad-mag-lite' ).'</span> ', ' '); ?>
    </div>
    <!-- kopa-tag-box --> 
<?php endif; ?>

<?php get_template_part('module/template','other-posts' ); ?>

<?php get_template_part('module/template','about-author' ); ?>

</div>
<?php endwhile; endif; ?>
</div>

<?php 
if(comments_open()){
    comments_template();
}
?>

</div>
<!-- kopa-main-col -->

<?php if(is_active_sidebar( 'right-sidebar' )) {
    echo '<div class="sidebar">';
    echo '<div class="ad-mag-right-sb">';
    dynamic_sidebar( 'right-sidebar' );
    echo '</div>';
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