<?php

add_action( 'widgets_init', function(){
	register_widget( 'Ad_Mag_Lite_Articles_List' );
});

/**
 * Widget article list
 */
class Ad_Mag_Lite_Articles_List extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'kp-article-list-widget', 'description' => __('Article list widget', 'ad-mag-lite'));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('Ad_Mag_Lite_Articles_List', __('(AdMag) Article List', 'ad-mag-lite'), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract( $args );

        if ( isset( $instance['title'] ) ) {
            $title  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        }
        
        if ( isset( $instance['style'] ) ) {
            $style  = $instance['style'];
        } else {
            $style = 'style_2';
        }

        if ( isset( $instance['excerpt_length'] ) ) {
            $limit  = $instance['excerpt_length'];
        }

        if ( isset( $instance['url'] ) ) {
            $url = $instance['url'];
        }

        $query_args = array(
            'post_type'      => 'post',
        );

        if ( isset( $instance['number'] ) ) {
            $query_args['posts_per_page'] = $instance['number'];
        }

        if ( isset( $instance['order'] ) ) {
            $query_args['order'] = $instance['order'] == 'ASC' ? 'ASC' : 'DESC';
        }

        if ( isset( $instance['orderby'] ) ) {
            $query_args['orderby'] = $instance['orderby'];
        }

        if( isset( $instance['categories'] )  && empty($instance['categories'] ) ) {
            $query_args['ignore_sticky_posts'] = true;
        }

        if ( isset( $instance['categories'] ) && $instance['categories'] ) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $instance['categories'],
            );
        }

        if ( isset( $instance['tags'] ) && $instance['tags'] ) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'post_tag',
                'field'    => 'term_id',
                'terms'    => $instance['tags'],
            );
        }

        if ( isset( $query_args['tax_query'] ) && 
             count( $query_args['tax_query'] ) === 2 ) {
            $query_args['tax_query']['relation'] = $instance['relation'];
        }
        
        $article = new WP_Query( $query_args );

        $num_post = count($article->posts);

        ?>

        <?php if($style == 'style_1') : ?> 
            <div class="widget kopa-article-list-widget article-list-1">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style2">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <ul class="clearfix">
                    <?php if ( $article->have_posts() ) : while( $article->have_posts() ) : $article->the_post() ?>
                        <li>
                            <article class="entry-item">
                                <?php if(has_post_thumbnail()) : ?>
                                    <div class="entry-thumb">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php the_post_thumbnail( 'ad-mag-lite-article-list-89x65' ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>   
                                <div class="entry-content">
                                    <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
                                    <div class="entry-meta">
                                        <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                    </div>
                                </div>
                            </article>
                        </li>
                    <?php endwhile; endif; ?>
                </ul>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_2') : ?> 
            <div class="widget kopa-article-list-widget article-list-2">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <?php $count = 0; $next = true; $stt = 1; ?>
                    <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                    <?php if($count == 0) { ?>
                        <article class="entry-item last-item">
                            <?php if(has_post_thumbnail()) : ?>
                                <div class="entry-thumb">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_post_thumbnail( 'ad-mag-lite-article-list-261x178' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="entry-content style1">
                                <span class="order-num"><?php if($stt < 10) echo '0'.$stt; else echo esc_html($stt); ?></span>
                                <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            </div>
                        </article>
                    <?php } else {
                        if($next) {
                            echo '<ul class="clearfix">';
                            $next = false;
                        }
                    ?>  
                        <li>
                            <article class="entry-item">
                                <span class="order-num"><?php if($stt < 10) echo '0'.$stt; else echo esc_html($stt); ?></span>
                                <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            </article>
                        </li>   
                    <?php
                     if($count == $num_post-1) {
                        echo '<li class="text-center">';

                        if(!empty($url)){
                            echo '<a class="more-link" href="'.$url.'">'.__('view more', 'ad-mag-lite').'</a>';
                        }

                        echo '</li></ul>';
                        }
                    }
                    $count++;
                    $stt++; 
                    ?>
                    <?php endwhile; endif; ?>                
                </div>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_3') : ?> 
            <div class="widget kopa-article-list-widget article-list-3">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="widget-content pd-20">
                    <?php $count = 0; $next = true; ?>
                    <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                    <?php if($count == 0) { ?>
                        <article class="entry-item last-item">
                            <?php if(has_post_thumbnail()) : ?>
                                <div class="entry-thumb style1">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_post_thumbnail( 'ad-mag-lite-article-list-510x271' ); ?>
                                    </a>
                                    <?php ad_mag_lite_the_first_category(get_the_id(),'h5-content'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="entry-content">
                                <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h4>
                                <div class="entry-meta">
                                    <?php ad_mag_lite_author_avatar(get_the_author_meta('ID'), true); ?>
                                    &nbsp;|&nbsp;
                                    <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                </div>
                                <?php the_excerpt(); ?>
                            </div>
                        </article>
                    <?php } else {
                        if($next) {
                            echo '<ul class="clearfix">';
                            $next = false;
                        }
                    ?>
                        <li>
                            <article class="entry-item">
                                <?php if(has_post_thumbnail()) : ?>
                                    <div class="entry-thumb style1">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php the_post_thumbnail( 'ad-mag-lite-article-list-261x178' ); ?>
                                        </a>
                                        <?php ad_mag_lite_the_first_category(get_the_id()); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="entry-content">
                                    <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <div class="entry-meta">
                                        <?php ad_mag_lite_author_avatar(get_the_author_meta('ID'), true); ?>
                                        &nbsp;|&nbsp;
                                        <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                    </div>
                                </div>
                            </article>
                        </li>
                    <?php
                     if($count == $num_post-1) {
                        echo '</ul>';
                        }
                    }
                    $count++; 
                    ?>
                <?php endwhile; endif; ?>
                </div>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_4') : ?> 
            <div class="widget kopa-article-list-widget article-list-4">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <ul class="clearfix">
                        <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                            <li>
                                <article class="entry-item">
                                    <?php if(has_post_thumbnail()) : ?>
                                        <div class="entry-thumb style1">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <?php the_post_thumbnail( 'ad-mag-lite-article-list-155x120' ); ?>
                                            </a>
                                            <?php ad_mag_lite_the_first_category(get_the_id()); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="entry-content">
                                        <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="entry-meta">
                                            <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                        </div>
                                        <?php the_excerpt(); ?>
                                    </div>
                                </article>
                            </li>
                        <?php endwhile; endif; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php if($style == 'style_5') : ?> 
            <div class="widget kopa-article-list-widget article-list-5">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <?php $count = 0; $next = true; ?>
                    <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                    <?php if($count == 0) { ?>
                        <article class="entry-item last-item">
                            <?php if(has_post_thumbnail()) : ?>
                                <div class="entry-thumb style1">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_post_thumbnail( 'ad-mag-lite-article-list-375x245' ); ?>
                                    </a>
                                    <?php ad_mag_lite_the_first_category(get_the_id()); ?>
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
                        </article>
                    <?php } else {
                        if($next) {
                            echo '<ul class="row clearfix">';
                            $next = false;
                        }
                    ?>
                        <li class="col-md-6 col-sm-6 col-xs-6">
                            <article class="entry-item">
                                <?php if(has_post_thumbnail()) : ?>
                                    <div class="entry-thumb style1">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php the_post_thumbnail( 'ad-mag-lite-article-list-176x120' ); ?>
                                        </a>
                                        <?php ad_mag_lite_the_first_category(get_the_id()); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="entry-content">
                                    <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <div class="entry-meta">
                                        <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                    </div>
                                    <?php the_excerpt(); ?>
                                </div>
                            </article>
                        </li>
                    <?php
                     if($count == $num_post-1) {
                        echo '</ul>';
                        }
                    }
                    $count++; 
                    ?>
                <?php endwhile; endif; ?>
                </div>
            </div>
            <!-- widget -->
        <?php endif; ?>

        <?php if($style == 'style_6') : ?>
            <div class="widget kopa-article-list-widget article-list-6">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <ul class="row clearfix">
                        <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                        <li class="col-md-4 col-sm-4 col-xs-4">
                            <article class="entry-item last-item">
                                <?php if(has_post_thumbnail()) : ?>
                                    <div class="entry-thumb style1">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php the_post_thumbnail( 'ad-mag-lite-article-list-261x178' ); ?>
                                        </a>
                                        <?php ad_mag_lite_the_first_category(get_the_id()); ?>
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
                            </article>
                        </li>
                    <?php endwhile; endif; ?>
                    </ul>
                </div>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_7') : ?> 
            <div class="widget kopa-article-list-widget article-list-7">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <ul class="clearfix">
                        <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                            <li>
                                <article class="entry-item">
                                    <div class="entry-content">
                                        <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="entry-meta">
                                            <?php ad_mag_lite_author_avatar(get_the_author_meta('ID'), true); ?>
                                            &nbsp;|&nbsp;
                                            <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                        </div>
                                    </div>
                                </article>
                            </li>
                        <?php endwhile; endif; ?>
                    </ul>
                </div>
                <?php if(!empty($url)) : ?>
                    <div class="kopa-view-all">
                        <a class="more-link" href="<?php echo esc_url($url); ?>"><?php _e('view all', 'ad-mag-lite'); ?></a>
                    </div>
                <?php endif; ?>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_8') : ?> 
            <div class="widget kopa-article-list-widget article-list-8">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <ul class="clearfix">
                        <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                            <li>
                                <article class="entry-item">
                                    <?php if(has_post_thumbnail()) : ?>
                                        <div class="entry-thumb">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <?php the_post_thumbnail( 'ad-mag-lite-article-list-261x178' ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="entry-content">
                                        <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="entry-meta">
                                            <?php ad_mag_lite_author_avatar(get_the_author_meta('ID'), true); ?>
                                            &nbsp;|&nbsp;
                                            <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                        </div>
                                    </div>
                                </article>
                            </li>
                        <?php endwhile; endif; ?>
                    </ul>
                </div>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_9') : ?> 
            <div class="widget kopa-article-list-widget article-list-9">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <ul id="items" class="clearfix" data-post-per-page=<?php echo esc_attr($instance['posts_per_page']); ?>>
                        <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                            <li>
                                <article class="entry-item">
                                    <?php if(has_post_thumbnail()) : ?>
                                        <div class="entry-thumb style1">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title();?>">
                                                <?php the_post_thumbnail( 'ad-mag-lite-article-list-261x178' ); ?>
                                            </a>
                                            <?php ad_mag_lite_the_first_category(get_the_id()); ?>
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
                                </article>
                            </li>
                        <?php endwhile; endif; ?>
                    </ul>
                    <div class="kopa-pagination-widget"></div>
                </div>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_10') : ?><!-- Dung o home 1 -->
            <div class="widget kopa-article-list-widget article-list-10">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <ul class="clearfix">
                        <?php if ( $article->have_posts() ) : while( $article->have_posts() ) : $article->the_post() ?>
                            <li>
                                <article class="entry-item">
                                    <?php if(has_post_thumbnail()) : ?>
                                        <div class="entry-thumb style1">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <?php the_post_thumbnail( 'ad-mag-lite-article-list-165x120' ); ?>
                                            </a>
                                        </div>
                                        <div class="entry-content">
                                            <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        </div>
                                    <?php endif; ?>
                                </article>
                            </li>
                        <?php endwhile; endif; ?>
                    </ul>
                </div>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_11') : ?><!-- Dung o home 1 -->
            <div class="widget kopa-article-list-widget article-list-11">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <ul class="clearfix">
                        <?php $index = 0; if ( $article->have_posts() ) : while( $article->have_posts() ) : $article->the_post(); $index++; ?>
                            <li>
                                <article class="entry-item">
                                    <div class="entry-content">
                                        <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    </div>
                                </article>
                            </li>
                        <?php endwhile; endif; ?>
                    </ul>
                </div>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_12') : ?>
            <div class="widget kopa-article-list-widget article-list-12">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <div class="item bgb">
                        <?php $count = 0; $next = true; ?>
                        <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                        <?php if($count == 0) { ?>
                        <article class="entry-item">
                            <?php if(has_post_thumbnail()) : ?>
                                <div class="entry-thumb">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_post_thumbnail( 'ad-mag-lite-article-list-165x120' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="entry-content">
                                <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <div class="entry-meta">
                                    <?php ad_mag_lite_author_avatar(get_the_author_meta('ID'), true); ?>
                                </div>
                            </div>
                        </article>
                        <?php } else {
                            if($next) {
                                echo '<ul class="kopa-e-list list-unorder style1">';
                                $next = false;
                            }
                        ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php
                            if($count == $num_post-1) {
                                echo '</ul>';
                                }
                            }
                            $count++; 
                            ?>
                        <?php endwhile; endif; ?>
                    </div>
                </div>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_13') : ?>
            <div class="widget kopa-article-list-widget article-list-13">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <?php $count = 0; $next = true; ?>
                    <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                    <?php if($count == 0) { $icon = get_post_format(get_the_id()); ?>
                    <article class="entry-item last-item <?php echo esc_attr($icon); ?>-post">
                        <?php if(has_post_thumbnail()) : ?>
                            <div class="entry-thumb style1">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <?php the_post_thumbnail( 'ad-mag-lite-article-list-261x178' ); ?>
                                </a>
                                <a  href="<?php the_permalink(); ?>" class="thumb-icon"></a>
                            </div>
                        <?php endif; ?>
                        <div class="entry-content">
                            <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <div class="entry-meta">
                                <?php ad_mag_lite_author_avatar(get_the_author_meta('ID'), true); ?>
                                &nbsp;|&nbsp;
                                <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                            </div>
                        </div>
                    </article>
                    <?php } else {
                        if($next) {
                            echo '<ul class="clearfix">';
                            $next = false;
                        }
                    ?>
                        <li>
                            <article class="entry-item">
                                <?php if(has_post_thumbnail()) : ?>
                                    <div class="entry-thumb">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php the_post_thumbnail( 'ad-mag-lite-article-list-85x75' ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="entry-content">
                                    <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <div class="entry-meta">
                                        <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <?php
                            if($count == $num_post-1) {
                                echo '</ul>';
                                }
                            }
                            $count++; 
                        ?>
                        <?php endwhile; endif; ?>
                </div>
            </div>
            <!-- widget -->
        <?php endif; ?>

        <?php if($style == 'style_14') : ?>
            <div class="widget kopa-article-list-widget article-list-14">
                <div class="pd-20">
                    <?php if( !empty($title)) : ?>
                        <h3 class="widget-title">
                            <?php echo esc_html($title); ?>
                        </h3>
                    <?php endif; ?>
                    <ul class="clearfix">
                        <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                            <li>
                                <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            </li>
                       <?php endwhile; endif; ?>
                    </ul>
                    <?php if(!empty($url)) : ?>
                        <a class="kopa-more-link" href="<?php echo esc_url($url); ?>"><?php _e('more view', 'ad-mag-lite'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- widget --> 
        <?php endif;?>

        <?php if($style == 'style_15') : ?>
            <div class="widget kopa-article-list-widget article-list-15">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <?php $count = 0; $next = true; ?>
                    <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                        <?php if($count == 0) {?>
                            <article class="entry-item last-item">
                                <?php if(has_post_thumbnail()) : ?>
                                    <div class="entry-thumb style2">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php the_post_thumbnail( 'ad-mag-lite-article-list-375x245' ); ?>
                                        </a>
                                        <a href="<?php the_permalink(); ?>" class="entry-view"><?php echo kopa_get_view_count(get_the_id()); ?></a>
                                    </div>
                                <?php endif; ?>
                                <div class="entry-content style2">
                                    <?php ad_mag_lite_the_first_category(get_the_id(),'h5-content'); ?>
                                    <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                </div>
                            </article>
                        <?php } else {
                            if($next) {
                                echo '<ul class="clearfix">';
                                $next = false;
                            }
                        ?>
                            <li class="">
                                <article class="entry-item">
                                    <?php if(has_post_thumbnail()) : ?>
                                        <div class="entry-thumb">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <?php the_post_thumbnail( 'ad-mag-lite-article-list-109x85' ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="entry-content">
                                        <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="entry-meta">
                                            <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                        </div> 
                                    </div>
                                </article>
                            </li>
                        <?php
                            if($count == $num_post-1) {
                                echo '</ul>';
                                }
                            }
                            $count++; 
                        ?>
                    <?php endwhile; endif; ?>
                </div>
            </div>
            <!-- widget -->
        <?php endif; ?>

        <?php if($style == 'style_16') : ?>
            <div class="widget kopa-article-list-widget article-list-16">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <ul class="clearfix">
                    <?php 
                    $query_args['posts_per_page'] = '1';
                    $articles = new WP_Query( $query_args );
                    if($articles->have_posts()) : while($articles->have_posts()) : $articles->the_post(); $id_post = get_the_id(); ?>
                        <li>
                            <article class="entry-item">
                                <div class="pd-20">
                                    <?php if(has_post_thumbnail()) : ?>
                                        <div class="entry-thumb style1">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <?php the_post_thumbnail( 'ad-mag-lite-article-list-538x316' ); ?>
                                            </a>
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
                                        <?php 
                                        $query_args['posts_per_page'] = $instance['number'] - 1;
                                        $query_args['offset'] = 1;
                                        $articles_sub = new WP_Query( $query_args );
                                        if($articles_sub->have_posts()) : ?>
                                            <ul class="kopa-e-list list-unorder style1">
                                                <?php while($articles_sub->have_posts()) : $articles_sub->the_post(); ?>
                                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                                <?php endwhile; wp_reset_postdata(); wp_reset_query(); ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>      
                            </article>
                        </li>
                    <?php endwhile; endif; ?>
                </ul>
            </div>
            <!-- widget --> 
        <?php endif;?>

        <?php if($style == 'style_16_std') : ?>
            <div class="widget kopa-article-list-widget article-list-16">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <ul id="items" class="clearfix" data-post-per-page=<?php echo esc_attr($instance['posts_per_page']); ?>>
                    <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                        <li>
                            <article class="entry-item">
                                <div class="pd-20">
                                    <?php if(has_post_thumbnail()) : ?>
                                        <div class="entry-thumb style1">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <?php the_post_thumbnail( 'ad-mag-lite-article-list-538x316' ); ?>
                                            </a>
                                            <?php ad_mag_lite_the_first_category(get_the_id()); ?>
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
                    <?php endwhile; endif; ?>
                </ul>
                <div class="kopa-pagination-widget"></div>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_17') : ?>
            <div class="widget kopa-article-list-widget article-list-17">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <ul class="clearfix">
                        <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); ?>
                            <li>
                                <article class="entry-item">
                                    <?php if(has_post_thumbnail()) : ?>
                                        <div class="entry-thumb">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <?php the_post_thumbnail( 'ad-mag-lite-article-list-140x110' ); ?>
                                            </a>
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
                                </article>
                            </li>
                        <?php endwhile; endif; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php if($style == 'style_18') : ?>
            <div class="widget kopa-article-list-widget article-list-18">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <div class="row">
                        <div class="owl-carousel owl-carousel-2">
                            <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); $icon = get_post_format(); ?>
                                <div class="item">
                                    <article class="entry-item <?php echo esc_attr($icon); ?>-post">
                                        <?php if(has_post_thumbnail()) : ?>
                                            <div class="entry-thumb">
                                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                    <?php the_post_thumbnail( 'ad-mag-lite-article-list-343x246' ); ?>
                                                </a>
                                                <a class="thumb-icon style1" href="<?php the_permalink(); ?>"></a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="entry-content style1">
                                            <?php ad_mag_lite_the_first_category(get_the_id(),'h5-content'); ?>
                                            <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        </div>
                                    </article>
                                </div>
                                <!-- item -->
                            <?php endwhile; endif; ?>
                        </div>
                        <!-- owl-carousel-2 -->
                    </div>
                    <!-- row --> 
                </div>
            </div>
            <!-- widget --> 
        <?php endif; ?>

        <?php if($style == 'style_19') : ?>
            <div class="widget kopa-article-list-widget article-list-19">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <div class="row">
                        <div class="owl-carousel owl-carousel-3">
                            <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); $icon = get_post_format(); ?>
                                <div class="item">
                                    <article class="entry-item <?php echo esc_attr($icon); ?>-post">
                                        <?php if(has_post_thumbnail()) : ?>
                                            <div class="entry-thumb">
                                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                    <?php the_post_thumbnail( 'ad-mag-lite-article-list-375x245' ); ?>
                                                </a>
                                                <a class="thumb-icon style1" href="<?php the_permalink(); ?>"></a>
                                            </div>
                                        <?php endif; ?>
                                        <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    </article>
                                </div>
                                <!-- item -->
                            <?php endwhile; endif; ?>
                        </div>
                        <!-- owl-carousel-3 -->
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if($style == 'style_20') : ?>
            <div class="widget kopa-article-list-widget article-list-20">
                <?php if( !empty($title)) : ?>
                    <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <div class="row">
                        <div class="owl-carousel owl-carousel-4">
                            <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); $icon = get_post_format(); ?>
                                <div class="item">
                                    <article class="entry-item <?php echo esc_attr($icon); ?>-post">
                                        <?php if(has_post_thumbnail()) : ?>
                                            <div class="entry-thumb">
                                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                    <?php the_post_thumbnail( 'ad-mag-lite-article-list-171x121' ); ?>
                                                </a>
                                                <a class="thumb-icon style1" href="<?php the_permalink(); ?>"></a>
                                            </div>
                                        <?php endif; ?>
                                        <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    </article>
                                </div>
                                <!-- item -->
                            <?php endwhile; endif; ?>
                        </div>
                        <!-- owl-carousel-4 -->
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if($style == 'style_21') : ?>
            <div class="widget kopa-article-list-widget article-list-21">
                <?php if( !empty($title)) : ?>
                   <h3 class="widget-title style5">
                        <?php echo esc_html($title); ?>
                   </h3>
                <?php endif; ?>
                <div class="owl-carousel owl-carousel-5">
                    <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); $icon = get_post_format(); ?>
                        <div class="item">
                            <article class="entry-item <?php echo esc_attr($icon); ?>-post">
                                <?php if(has_post_thumbnail()) : ?>
                                    <div class="entry-thumb">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php the_post_thumbnail( 'ad-mag-lite-article-list-375x245' ); ?>
                                        </a>
                                        <a class="thumb-icon style1" href="<?php the_permalink(); ?>"></a>
                                    </div>
                                <?php endif; ?>
                                <div class="entry-content style1">
                                    <?php ad_mag_lite_the_first_category(get_the_id(),'h5-content'); ?>
                                    <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                </div>
                            </article>
                        </div>
                        <!-- item -->
                    <?php endwhile; endif; ?>
                </div>
                <!-- owl-carousel-5 -->
            </div>
        <?php endif; ?>

        <?php if($style == 'style_22') : ?>
            <div class="widget kopa-article-list-widget article-list-22">
                <?php if( !empty($title)) : ?>
                   <h3 class="widget-title style3">
                        <?php echo esc_html($title); ?>
                   </h3>
                <?php endif; ?>
                <div class="pd-20">
                    <?php $count = 0; $next = true; ?>
                    <?php if($article->have_posts()) : while($article->have_posts()) : $article->the_post(); $icon = get_post_format(); ?>
                    <?php if($count == 0) { ?>
                        <article class="entry-item last-item <?php echo esc_attr($icon); ?>-post">
                            <?php if(has_post_thumbnail()) : ?>
                                <div class="entry-thumb">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_post_thumbnail( 'ad-mag-lite-article-list-375x245' ); ?>
                                    </a>
                                    <a class="thumb-icon style1" href="<?php the_permalink(); ?>"></a>
                                </div>
                            <?php endif; ?>
                            <div class="entry-content style1">
                                <?php ad_mag_lite_the_first_category(get_the_id(),'h5-content'); ?>
                                <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <div class="entry-meta">
                                    <?php ad_mag_lite_author_avatar(get_the_author_meta('ID'), true); ?>
                                    &nbsp;|&nbsp;
                                    <span class="entry-date"><i class="fa fa-clock-o"></i><?php echo get_the_date('M j, Y'); ?></span>
                                </div>
                            </div>
                        </article>
                    <?php } else {
                        if($next) {
                            echo '<ul id="items" class="clearfix" data-post-per-page="'.$instance['posts_per_page'].'">';
                            $next = false;
                        }
                    ?>
                        <li>
                            <article class="entry-item <?php echo esc_attr($icon); ?>-post">
                                <?php if(has_post_thumbnail()) : ?>
                                    <div class="entry-thumb">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php the_post_thumbnail( 'ad-mag-lite-article-list-375x245' ); ?>
                                        </a>
                                        <a class="thumb-icon style1" href="<?php the_permalink(); ?>"></a>
                                        <?php ad_mag_lite_the_first_category(get_the_id(),'h5-content'); ?>
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
                            </article>
                        </li>
                    <?php
                        if($count == $num_post-1) {
                            echo '</ul>';
                            }
                        }
                        $count++; 
                    ?>
                    <?php endwhile; endif; ?>
                    <div class="kopa-pagination-widget"></div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        wp_reset_postdata();
    }

    function form($instance) {
        $default = array(
            'title'          => '',
            'categories'     => array(),
            'relation'       => 'OR',
            'tags'           => array(),
            'order'          => 'DESC',
            'orderby'        => 'rand', 
            'number'         => 5,
            'posts_per_page' => 4,
            'excerpt_length' => 10,
            'style'          => 'style_1',
            'url'            => '#',
            
        );
        $instance = wp_parse_args((array) $instance, $default);
        $title = strip_tags($instance['title']);

        $form['categories']     = $instance['categories'];
        $form['relation']       = esc_attr($instance['relation']);
        $form['tags']           = $instance['tags'];
        $form['order']          = $instance['order'];
        $form['orderby']        = $instance['orderby'];
        $form['number']         = (int)$instance['number'];
        $form['excerpt_length'] = (int)$instance['excerpt_length'];
        $form['style']          = $instance['style']; 
        $form['posts_per_page'] = $instance['posts_per_page'];
        $form['url']            = $instance['url']; 
        ?>

    <p>
        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'ad-mag-lite'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id( 'categories' )); ?>"><?php _e( 'Categories', 'ad-mag-lite' ); ?></label>
        <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'categories' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'categories' )) ?>[]" multiple="multiple" size="5">
            <option value=""><?php _e('--Select--', 'ad-mag-lite'); ?></option>
            <?php
            $categories = get_categories();
            foreach ($categories as $category) :
                ?>
                <option value="<?php echo esc_attr($category->term_id); ?>" <?php echo in_array($category->term_id, $form['categories']) ? 'selected="selected"' : ''; ?>>
                    <?php echo esc_attr($category->name).' ('.$category->count.')'; ?></option>
                <?php
            endforeach;
            ?>
        </select>
    </p>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id('relation')); ?>"><?php _e('Relation', 'ad-mag-lite'); ?>:</label>
        <select class="widefat" name="<?php echo esc_attr($this->get_field_name('relation')); ?>" id="<?php echo esc_attr($this->get_field_id('relation')); ?>">
            <option value="OR" <?php selected('OR', $form['relation']); ?>><?php _e('OR', 'ad-mag-lite'); ?></option>
            <option value="AND" <?php selected('AND', $form['relation']); ?>><?php _e('AND', 'ad-mag-lite'); ?></option>
        </select>
    </p>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id( 'tags' )); ?>"><?php _e( 'Tags', 'ad-mag-lite' ); ?></label>
        <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tags' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tags' )) ?>[]" multiple="multiple" size="5">
            <option value=""><?php _e('--Select--', 'ad-mag-lite'); ?></option>
            <?php
            $tags = get_tags();
            foreach ($tags as $category) :
                ?>
                <option value="<?php echo esc_attr($category->term_id); ?>" <?php echo in_array($category->term_id, $form['tags']) ? 'selected="selected"' : ''; ?>>
                    <?php echo esc_attr($category->name).' ('.$category->count.')'; ?></option>
                <?php
            endforeach;
            ?>
        </select>
    </p>
    
    <p>
        <label for="<?php echo esc_attr($this->get_field_id( 'order' )); ?>"><?php _e( 'Order', 'ad-mag-lite' ); ?></label>
        <select class="widefat" name="<?php echo esc_attr($this->get_field_name( 'order' )); ?>" id="<?php echo esc_attr($this->get_field_id('order' )); ?>">
            <?php $order = array(
            'ASC'  => __('ASC', 'ad-mag-lite'),
            'DESC' => __('DESC', 'ad-mag-lite')
        );

            foreach ($order as $value => $label) :
                ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($value, $form['order']); ?>><?php echo esc_attr($label); ?></option>
                <?php
            endforeach;
            ?>
        </select>
    </p>

    <p>
        <label for="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>"><?php _e( 'Orderby', 'ad-mag-lite' ); ?></label>
        <select class="widefat" name="<?php echo esc_attr($this->get_field_name( 'orderby' )); ?>" id="<?php echo esc_attr($this->get_field_id('orderby' )); ?>">
            <?php $orderby = array(
            'date'          => __('Date', 'ad-mag-lite'),
            'rand'          => __('Random', 'ad-mag-lite'),
            'comment_count' => __('Number of comments', 'ad-mag-lite')
        );

            foreach ($orderby as $value => $label) :
                ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($value, $form['orderby']); ?>><?php echo esc_attr($label); ?></option>
                <?php
            endforeach;
            ?>
        </select>
    </p>

    <p>
        <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number of post:', 'ad-mag-lite'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" value="<?php echo esc_attr($form['number']); ?>" min="1" />
    </p>

    <p>
        <label for="<?php echo esc_attr($this->get_field_id('posts_per_page')); ?>"><?php _e('Posts per page:', 'ad-mag-lite'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('posts_per_page')); ?>" name="<?php echo esc_attr($this->get_field_name('posts_per_page')); ?>" value="<?php echo esc_attr($form['posts_per_page']); ?>" type="number" min="1">
    </p>

    <p>
        <label for="<?php echo esc_attr($this->get_field_id('excerpt_length')); ?>"><?php _e('Custom excerpt length:', 'ad-mag-lite'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('excerpt_length')); ?>" name="<?php echo esc_attr($this->get_field_name('excerpt_length')); ?>" type="number" value="<?php echo esc_attr($form['excerpt_length']); ?>" min="1" />
    </p>

    <p>
        <label for="<?php echo esc_attr($this->get_field_id( 'style' )); ?>"><?php _e( 'Style:', 'ad-mag-lite' ); ?></label>
        <select class="widefat" name="<?php echo esc_attr($this->get_field_name( 'style' )); ?>" id="<?php echo esc_attr($this->get_field_id('style' )); ?>">
        <?php 
        $style = array(
            'style_1'      => __( 'Style 1', 'ad-mag-lite' ),
            'style_2'      => __( 'Style 2 Home 1', 'ad-mag-lite' ),
            'style_3'      => __( 'Style 3 Home 1', 'ad-mag-lite' ),
            'style_4'      => __( 'Style 4 Home 1', 'ad-mag-lite' ),
            'style_5'      => __( 'Style 5 Home 1', 'ad-mag-lite' ),
            'style_6'      => __( 'Style 6 Home 1', 'ad-mag-lite' ),
            'style_7'      => __( 'Style 7 Home 1 ', 'ad-mag-lite' ),
            'style_8'      => __( 'Style 8 Home 1', 'ad-mag-lite' ),
            'style_9'      => __( 'Style 9 Home 1', 'ad-mag-lite' ),
            'style_10'     => __( 'Style 10 Home 1', 'ad-mag-lite' ),
            'style_11'     => __( 'Style 11 Home 1', 'ad-mag-lite' ),
            'style_12'     => __( 'Style 12 Home 1', 'ad-mag-lite' ),
            'style_13'     => __( 'Style 13 Home 1', 'ad-mag-lite' ),
            'style_14'     => __( 'Style 14 Home 2', 'ad-mag-lite' ),
            'style_15'     => __( 'Style 15 Home 2', 'ad-mag-lite' ),
            'style_16'     => __( 'Style 16 Blog 1', 'ad-mag-lite' ),
            'style_16_std' => __( 'Style 16 Home 2', 'ad-mag-lite' ),
            'style_17'     => __( 'Style 17 Home 3', 'ad-mag-lite' ),
            'style_18'     => __( 'Style 18 Home 4', 'ad-mag-lite' ),
            'style_19'     => __( 'Style 19 Home 4', 'ad-mag-lite' ),
            'style_20'     => __( 'Style 20 Home 4', 'ad-mag-lite' ),
            'style_21'     => __( 'Style 21 Home 4', 'ad-mag-lite' ),
            'style_22'     => __( 'Style 22 Home 4', 'ad-mag-lite' )
        );

            foreach ($style as $value => $label) :
        ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($value, $form['style']); ?>><?php echo esc_attr($label); ?></option>
                <?php
            endforeach;
            ?>
        </select>
    </p>

    <p>
        <label for="<?php echo esc_attr($this->get_field_id('url')); ?>"><?php _e('View more URL:', 'ad-mag-lite'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('url')); ?>" name="<?php echo esc_attr($this->get_field_name('url')); ?>" value="<?php echo esc_attr($form['url']); ?>" type="text">
    </p>

    <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title']          = strip_tags($new_instance['title']);
        $instance['categories']     = (empty($new_instance['categories'])) ? array() : array_filter($new_instance['categories']);
        $instance['relation']       = $new_instance['relation'];
        $instance['tags']           = (empty($new_instance['tags'])) ? array() : array_filter($new_instance['tags']);
        $instance['order']          = $new_instance['order'];
        $instance['orderby']        = $new_instance['orderby'];
        $instance['number']         = (int)$new_instance['number'];
        $instance['excerpt_length'] = (int)$new_instance['excerpt_length'];
        $instance['style']          = $new_instance['style'];
        $instance['posts_per_page'] = (int) $new_instance['posts_per_page'];
        $instance['url']            = $new_instance['url'];
        
        return $instance;
    }
}