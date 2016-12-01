<?php
$prev_post = get_previous_post();
$next_post = get_next_post();

?>
<?php if ( ( get_next_post() || get_previous_post() ) ) :?>

    <div class="single-other-post">
        <div class="clearfix">

            <?php if (!empty( $prev_post )):
                $categories = get_the_category($prev_post->ID);
                $category = null;
                if( !empty($categories) ) {
                    $category = $categories[0];
                }
            ?>

                <div class="entry-item prev-post">
                    <?php if(has_post_thumbnail($prev_post->ID)) : ?>
                        <div class="entry-thumb">
                            <a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>">
                                <?php echo get_the_post_thumbnail( $prev_post->ID , 'ad-mag-lite-article-list-blog-75x75' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="entry-content">
                        <a href="<?php echo get_permalink( $prev_post->ID ); ?>" class=""><?php _e('PREVIOUS POST', 'ad-mag-lite'); ?></a>
                        <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo esc_html($prev_post->post_title); ?></a></h4>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($next_post)) :
                $categories_next = get_the_category($next_post->ID);
                $category_next = null;
                if ( !empty($categories_next) ) {
                    $category_next = $categories_next[0];
                }
            ?>
                <div class="entry-item next-post">
                    <?php if(has_post_thumbnail($next_post->ID)) : ?>
                        <div class="entry-thumb">
                            <a href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo esc_attr($next_post->post_title); ?>">
                                <?php echo get_the_post_thumbnail( $next_post->ID ,'ad-mag-lite-article-list-blog-75x75' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="entry-content">
                        <a href="<?php echo get_permalink( $next_post->ID ); ?>" class=""><?php _e('NEXT POST', 'ad-mag-lite'); ?></a>
                        <h4 class="entry-title" itemscope="" itemtype="http://schema.org/Event"><a itemprop="name" href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo esc_html($next_post->post_title); ?></a></h4>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <!-- single-other-post -->
<?php endif; ?>