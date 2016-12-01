<?php

if (!function_exists('ad_mag_lite_load_more_blog_3')) {
    add_action('wp_ajax_ad_mag_lite_load_more_blog_3', 'ad_mag_lite_load_more_blog_3');
    add_action('wp_ajax_nopriv_ad_mag_lite_load_more_blog_3', 'ad_mag_lite_load_more_blog_3');

    function ad_mag_lite_load_more_blog_3() {
        if ( ! wp_verify_nonce($_POST['wpnonce'], 'ad_mag_lite_load_more_blog_3')) {
            throw new Exception( __( 'Sorry an error has occurred.', 'ad-mag-lite' ) );
            exit();
        }
        global $wp_query;
        $offset = 0;

        $offset = intval( $_POST['postoffset'] );
        $cat_id = intval( $_POST['cat_id'] );
        $args = array(
            'offset' => $offset,
            'posts_per_page' => get_option('posts_per_page'),
            'cat' => $cat_id
        );

        $wp_query = new WP_Query( $args ); ?>

       <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); $icon = get_post_format(); ?>    
                <li class="ms-item6 size2">
                    <article class="entry-item <?php echo esc_attr($icon); ?>-post">
                        <div class="pd-20">
                            <?php if(has_post_thumbnail()) : ?>
                                <div class="entry-thumb style1">
                                <?php the_post_thumbnail( 'ad-mag-lite-article-list-blog-375x190' ); ?>
                                <?php ad_mag_lite_the_first_category(get_the_id()); ?>
                                    <a class="thumb-icon style1" href="<?php the_permalink(); ?>"></a>
                                </div>
                            <?php endif; ?>
                            <div class="entry-content">
                                <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <div class="entry-meta">
                                    <?php ad_mag_lite_author_avatar(get_the_author_meta('ID'), true); ?>
                                    &nbsp;|&nbsp;
                                    <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                </div>
                                <?php the_excerpt(); ?>
                            </div>
                        </div>       
                    </article>
                </li>
            <?php endwhile; ?>
        <?php endif; ?> 
        <?php
        exit;
       
        die();
    }
}

if (!function_exists('ad_mag_lite_load_more_blog_2')) {
    add_action('wp_ajax_ad_mag_lite_load_more_blog_2', 'ad_mag_lite_load_more_blog_2');
    add_action('wp_ajax_nopriv_ad_mag_lite_load_more_blog_2', 'ad_mag_lite_load_more_blog_2');

    function ad_mag_lite_load_more_blog_2() {
        if ( ! wp_verify_nonce($_POST['wpnonce'], 'ad_mag_lite_load_more_blog_2')) {
            throw new Exception( __( 'Sorry an error has occurred.', 'ad-mag-lite' ) );
            exit();
        }

        global $wp_query;
        $offset = 0;
        $offset = intval( $_POST['postoffset'] );
        $cat_id = intval( $_POST['cat_id'] );
        $index = intval( $_POST['index'] );

        $args = array(
            'offset' => $offset,
            'posts_per_page' => get_option('posts_per_page'),
            'cat' => $cat_id
        );

        $limit = 15;
        $wp_query = new WP_Query( $args ); ?>

       <?php if (have_posts()) : ?>
            <?php 
            while (have_posts()) : the_post(); $icon = get_post_format(); $temp = $index + 1; $index = $temp; ?> 
            <?php if($index == 3 || $index == 4 || $index == 5){
                       $class = 'ms-item6 size2';
                   }else{
                       $class = 'ms-item6';
                   }
                   if($index == 5){
                       $index = 0;
                   } ?>
                <li data-index="<?php echo esc_attr($index); ?>" class="<?php echo esc_attr($class); ?>">
                    <article class="entry-item <?php echo esc_attr($icon); ?>-post">
                        <div class="pd-20">
                            <?php if(has_post_thumbnail()) : ?>
                                <div class="entry-thumb style1">
                                    <?php the_post_thumbnail( 'ad-mag-lite-article-list-blog-375x190' ); ?>
                                <?php ad_mag_lite_the_first_category(get_the_id()); ?>
                                    <a class="thumb-icon style1" href="<?php the_permalink(); ?>"></a>
                                </div>
                            <?php endif; ?>
                            <div class="entry-content">
                                <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <div class="entry-meta">
                                    <?php ad_mag_lite_author_avatar(get_the_author_meta('ID'), true); ?>
                                    &nbsp;|&nbsp;
                                    <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                </div>
                                <?php the_excerpt(); ?>
                            </div>
                        </div>      
                    </article>
                </li>
            <?php endwhile; ?>
        <?php endif; ?> 
        <?php
        exit;
       
        die();
    }
}