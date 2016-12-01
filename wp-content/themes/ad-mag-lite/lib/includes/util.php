<?php

function ad_mag_lite_log($message){
    if (WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}

function ad_mag_lite_content_get_media($content, $enable_multi = false, $media_types = array()) {
    $media = array();
    $regex_matches = '';
    $regex_pattern = get_shortcode_regex();
    preg_match_all('/' . $regex_pattern . '/s', $content, $regex_matches);
    foreach ($regex_matches[0] as $shortcode) {
        $regex_matches_new = '';
        preg_match('/' . $regex_pattern . '/s', $shortcode, $regex_matches_new);
        if (in_array($regex_matches_new[2], $media_types)) :
            $media[] = array(
                'shortcode' => $regex_matches_new[0],
                'type' => $regex_matches_new[2],
                'url' => $regex_matches_new[5]
                );
        if (false == $enable_multi) {
            break;
        }
        endif;
    }    
    return $media;
}

function ad_mag_lite_content_get_gallery($content, $enable_multi = false) {
    return ad_mag_lite_content_get_media($content, $enable_multi, array('gallery'));
}

function ad_mag_lite_content_get_quote($content, $enable_multi = false) {
    return ad_mag_lite_content_get_media($content, $enable_multi, array('gallery'));
}

function ad_mag_lite_content_get_audio($content, $enable_multi = false) {
    return ad_mag_lite_content_get_media($content, $enable_multi, array('audio', 'soundcloud'));
}

function ad_mag_lite_content_get_video($content, $enable_multi = false) {
    return ad_mag_lite_content_get_media($content, $enable_multi, array('vimeo', 'youtube', 'video', 'embed', 'wpvideo'));
}

/**
 * Get gallery string ids after getting matched gallery array
 * @return array of attachment ids in gallery
 * @return empty if no gallery were found
 */
function ad_mag_lite_content_get_gallery_attachment_ids( $content ) {
    $gallery = ad_mag_lite_content_get_gallery( $content );

    if (isset( $gallery[0] )) {
        $gallery = $gallery[0];
    } else {
        return '';
    }

    if ( isset($gallery['shortcode']) ) {
        $shortcode = $gallery['shortcode'];
    } else {
        return '';
    }

    // get gallery string ids
    preg_match_all('/ids=\"(?:\d+,*)+\"/', $shortcode, $gallery_string_ids);
    if ( isset( $gallery_string_ids[0][0] ) ) {
        $gallery_string_ids = $gallery_string_ids[0][0];
    } else {
        return '';
    }

    // get array of image id
    preg_match_all('/\d+/', $gallery_string_ids, $gallery_ids);
    if ( isset( $gallery_ids[0] ) ) {
        $gallery_ids = $gallery_ids[0];
    } else {
        return '';
    }

    return $gallery_ids;
}

/**
 * Template tag: Show socials link
 */
function ad_mag_lite_social() {
    $social_links = array(
        'social_facebook'  => array(
            'url'     => '',
            'icon'    => 'fa-facebook',
            'display' => false,
            'name' => 'Facebook'
        ),
        'social_twitter'   => array(
            'url'    => '',
            'icon'   => 'fa-twitter',
            'display' => false,
            'name' => 'Twitter'
        ),
        'social_google_plus' => array(
            'url'    => '',
            'icon'   => 'fa-google-plus',
            'display' => false,
            'name' => 'Google +'
        ),
        'social_linkedin'     => array(
            'url'    => '',
            'icon'   => 'fa-linkedin',
            'display' => false,
            'name' => 'Linkedin'
        ),
        'social_tumblr'     => array(
            'url'    => '',
            'icon'   => 'fa-tumblr',
            'display' => false,
            'name' => 'Tumblr'
        ),
        'social_pinterest'     => array(
            'url'    => '',
            'icon'   => 'fa-pinterest',
            'display' => false,
            'name' => 'Pinterest'
        ),
        'social_rss'  => array(
            'url'    => '',
            'icon'   => 'fa-rss',
            'display' => false,
            'name' => 'RSS'
        ),
    );
    $display = false;
    foreach( $social_links as $social_name => $social_atts ) {
        $option_name = $social_name;
        $social_atts['url'] = get_theme_mod( $option_name, '' );

        if ( 'social_rss' == $social_name ) {
            if ( empty( $social_atts['url'] ) ) {
                $social_atts['url'] = get_bloginfo('rss2_url');
                $social_atts['display'] = true;
                $display = true;
            } elseif ( $social_atts['url'] != 'HIDE' ) {
                $social_atts['url'] = esc_url( $social_atts['url'] );
                $social_atts['display'] = true;
            }
        } else {
            $social_atts['url'] = esc_url( $social_atts['url'] );
            if ( !empty( $social_atts['url'] ) ) { $social_atts['display'] = true; $display = true;}
        }

        $social_links[ $social_name ] = $social_atts;
    }

    $target = '_blank';
    ?>
        <?php if($display) : ?>
            <div class="kopa-social-links pull-right">
                <ul class="clearfix">
                    <?php foreach ( $social_links as $social_name => $social_atts) { ?>
                        <?php if ( $social_atts['display'] ) { ?>
                            <li>
                                <a href="<?php echo esc_url($social_atts['url']); ?>" target="<?php echo esc_attr($target); ?>" rel="nofollow" class="fa <?php echo esc_attr($social_atts['icon']); ?>"></a>
                            </li>
                        <?php } // endif ?>
                    <?php } // endforeach ?>
                </ul>
            </div>
            <!-- kopa-social-links -->
        <?php endif; ?>
    <?php
}

/*
 * Template tag: Show headline
 */
function ad_mag_lite_top_headline(){
    $limit = 5;
    $title = __( 'Breaking News', 'ad-mag-lite' );
    // Headline Category
    $terms = get_terms('category');
    $arr_cat = array(
        '' => __('----SELECT----', 'ad-mag-lite')
        );
    foreach($terms as $v) 
        $arr_cat[$v->term_id] = $v->name . '(' . $v->count . ')';

    if ($limit) {
        $cats = (array)$arr_cat;
        $cats = implode(',', $cats);

        if( !empty($cats) ){
            $posts = new WP_Query('cat='.$cats.'&posts_per_page='.$limit);
        }else{
            $posts = new WP_Query( 'posts_per_page='.$limit);
        }
        ?>
            <div class="header-top-left">

                <div class="kopa-ticker">
                    <?php if(!empty($title)) : ?>
                        <h6 class="ticker-title"><?php echo esc_html($title); ?></h6>
                    <?php endif; ?>
                    <ul id="js-news" class="">
                        <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <!--/end kopa-ticker-->

            </div> 
            <!-- header-top-left -->  
        <?php
        wp_reset_query();
    }
}

/*
 * Template tag: Show breadcrumb
 */
function ad_mag_lite_get_breadcrumb() {

    if (is_main_query()) {
        global $post, $wp_query;

        $prefix = '&nbsp;|&nbsp;';
        $current_class = 'current-page';
        $description = '';
        $breadcrumb_before = '<div class="kopa-breadcrumb"><div class="wrapper clearfix">';
        $breadcrumb_after = '</div></div>';
        $breadcrumb_home = '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="' . esc_url( home_url('/') ) . '"><span itemprop="title">' . __('Home', 'ad-mag-lite') . '</span></a></span>';
        $breadcrumb = '';
        ?>

        <?php
        if (is_home()) {
            $breadcrumb.= $breadcrumb_home;
            $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, __('Blog', 'ad-mag-lite'));                
        } else if (is_post_type_archive('product') && get_option('woocommerce_shop_page_id')) {
            $breadcrumb.= $breadcrumb_home;

            $breadcrumb.= $prefix . sprintf('<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" class="%1$s"><span itemprop="title">%2$s</span></a></span>', $current_class, get_the_title(get_option('woocommerce_shop_page_id')));
        } else if (is_tag()) {
            $breadcrumb.= $breadcrumb_home;

            $term = get_term(get_queried_object_id(), 'post_tag');
            $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, $term->name);
        } else if (is_category()) {
            $breadcrumb.= $breadcrumb_home;

            $category_id = get_queried_object_id();
            $terms_link = explode(',', substr(get_category_parents(get_queried_object_id(), TRUE, ','), 0, (strlen(',') * -1)));
            $n = count($terms_link);
            if ($n > 1) {
                for ($i = 0; $i < ($n - 1); $i++) {
                    $breadcrumb.= $prefix . $terms_link[$i];
                }
            }
            $breadcrumb.= $prefix . sprintf('<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" class="%1$s"><span itemprop="title">%2$s</span></a></span>', $current_class, get_the_category_by_ID(get_queried_object_id()));

        } else if ( is_tax('product_cat') ) {
            $breadcrumb.= $breadcrumb_home;
            $breadcrumb.= $prefix . '<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'.get_page_link( get_option('woocommerce_shop_page_id') ).'"><span itemprop="title">'.get_the_title( get_option('woocommerce_shop_page_id') ).'</span></a></span>';
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

            $parents = array();
            $parent = $term->parent;
            while ($parent):
                $parents[] = $parent;
                $new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ));
                $parent = $new_parent->parent;
            endwhile;
            if( ! empty( $parents ) ):
                $parents = array_reverse($parents);
                foreach ($parents as $parent):
                    $item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ));
                    $breadcrumb .= $prefix . '<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="' .esc_url( get_term_link( $item->slug, 'product_cat' ) ). '"><span itemprop="title">' . $item->name . '</span></a></span>';
                endforeach;
            endif;

            $queried_object = get_queried_object();
            // $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, $queried_object->name);
            $breadcrumb.= $prefix . sprintf('<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" class="%1$s"><span itemprop="title">%2$s</span></a></span>', $current_class, $queried_object->name);
        } else if ( is_tax( 'product_tag' ) ) {
            $breadcrumb.= $breadcrumb_home;
            $breadcrumb.= $prefix . '<a href="'.esc_url ( get_page_link( get_option('woocommerce_shop_page_id') ) ).'">'.get_the_title( get_option('woocommerce_shop_page_id') ).'</a>';
            $queried_object = get_queried_object();
            $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, $queried_object->name);
        } else if (is_single()) {
            global $post;
            $breadcrumb.= $breadcrumb_home;
            if ( is_singular('product')) :
                $breadcrumb .= $prefix . '<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.esc_url( get_page_link( get_option('woocommerce_shop_page_id') ) ).'" itemprop="url"><span itemprop="title">'.get_the_title( get_option('woocommerce_shop_page_id') ).'</span></a></span>';

                if ($terms = get_the_terms( $post->ID, 'product_cat' )) :
                    $term = apply_filters( 'jigoshop_product_cat_breadcrumb_terms', current($terms), $terms);
                    $parents = array();
                    $parent = $term->parent;
                    while ($parent):
                        $parents[] = $parent;
                        $new_parent = get_term_by( 'id', $parent, 'product_cat');
                        $parent = $new_parent->parent;
                    endwhile;
                    if(!empty($parents)):
                        $parents = array_reverse($parents);
                        foreach ($parents as $parent):
                            $item = get_term_by( 'id', $parent, 'product_cat');
                            $breadcrumb .= $prefix . '<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . esc_url ( get_term_link( $item->slug, 'product_cat' ) ) . '" itemprop="url"><span itemprop="title">' . $item->name . '</span></a></span>';
                        endforeach;
                    endif;
                    $breadcrumb .= $prefix . '<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . esc_url ( get_term_link( $term->slug, 'product_cat' ) ) . '" itemprop="url"><span itemprop="title">' . $term->name . '</span></a></span>';
                endif;

                $breadcrumb.= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', $current_class, get_the_title(get_queried_object_id()));
            else : 
                $categories = get_the_category(get_queried_object_id());
                if ($categories) {
                    foreach ($categories as $category) {
                        $breadcrumb.= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="%1$s" itemprop="url"><span itemprop="title">%2$s</span></a></span>', esc_url( get_category_link($category->term_id) ), $category->name);
                    }
                }

                $post_id = get_queried_object_id();
                $breadcrumb.= $prefix . sprintf('<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" class="%1$s"><span itemprop="title">%2$s</span></a></span>', $current_class, get_the_title(get_queried_object_id()));
                
            endif;

        } else if (is_page()) {
            if (!is_front_page()) {
                $post_id = get_queried_object_id();
                $breadcrumb.= $breadcrumb_home;
                $post_ancestors = get_post_ancestors($post);
                if ($post_ancestors) {
                    $post_ancestors = array_reverse($post_ancestors);
                    foreach ($post_ancestors as $crumb)
                        $breadcrumb.= $prefix . sprintf('<a href="%1$s">%2$s</a>', get_permalink($crumb), get_the_title($crumb));
                }
                $breadcrumb.= $prefix . sprintf('<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" class="%1$s"><span itemprop="title">%2$s</span></a></span>', $current_class, get_the_title(get_queried_object_id()));
            }
        } else if (is_year() || is_month() || is_day()) {
            $breadcrumb.= $breadcrumb_home;

            $date = array('y' => NULL, 'm' => NULL, 'd' => NULL);

            $date['y'] = get_the_time('Y');
            $date['m'] = get_the_time('m');
            $date['d'] = get_the_time('j');

            if (is_year()) {
                $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, $date['y']);
            }

            if (is_month()) {
                $breadcrumb.= $prefix . sprintf('<a href="%1$s">%2$s</a>', esc_url( get_year_link($date['y']) ), $date['y']);
                $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, date_i18n('F', $date['m']));
            }

            if (is_day()) {
                $breadcrumb.= $prefix . sprintf('<a href="%1$s">%2$s</a>', esc_url( get_year_link($date['y'])), $date['y']);
                $breadcrumb.= $prefix . sprintf('<a href="%1$s">%2$s</a>', esc_url( get_month_link($date['y'], $date['m'])), date_i18n('F', $date['m']));
                $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, $date['d']);
            }

        } else if (is_search()) {
            $breadcrumb.= $breadcrumb_home;

            $s = get_search_query();
            $c = $wp_query->found_posts;

            $description = sprintf(__('<span class="%1$s">Your search for "%2$s"', 'ad-mag-lite'), $current_class, $s);
            $breadcrumb .= $prefix . $description;
        } else if (is_author()) {
            $breadcrumb.= $breadcrumb_home;
            $author_id = get_queried_object_id();
            $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</a>', $current_class, sprintf(__('Posts created by %1$s', 'ad-mag-lite'), get_the_author_meta('display_name', $author_id)));
        } else if (is_404()) {
            $breadcrumb.= $breadcrumb_home;
            
            $breadcrumb.= $prefix . sprintf('<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="" class="%1$s"><span itemprop="title">%2$s</span></a></span>', $current_class, __('Error 404', 'ad-mag-lite'));
        }

        if ($breadcrumb)
            echo apply_filters('ad_mag_lite_breadcrumb', $breadcrumb_before . $breadcrumb . $breadcrumb_after);
    }
}

function ad_mag_lite_register_new_image_sizes(){
    add_image_size( 'ad-mag-lite-post-thumb', 410, 370, true );                                                                      
}

/**
 * Show first single's category
 */
function ad_mag_lite_the_first_category($ID,$class = ''){
  
    global $post;
    if($post->post_type == 'page'){
        return;
    }
    if($post->post_type == 'product'){
        $terms = get_the_terms( $post->ID, 'product_cat' );
        if($terms){
            foreach ($terms as $term) {
                $product_cat = $term->name;
                $product_cat_link = esc_url( get_term_link( $term->term_id, 'product_cat' ) );
                break;
            }
            echo '<h5><a href="'.esc_url($product_cat_link).'">'.$product_cat.'</a></h5>';
        }
    }else{
        $category = get_the_category($ID);
        $category_link = esc_url( get_category_link( $category[0]->cat_ID ) );
        if(!empty($class)){
            echo '<h5 class="'.$class.' custom-color-'.$category[0]->cat_ID.'"><a href="'.esc_url($category_link).'">'.$category[0]->cat_name.'</a></h5>';
        }else{
            echo '<h5 class="custom-color-'.$category[0]->cat_ID.'"><a href="'.esc_url($category_link).'">'.$category[0]->cat_name.'</a></h5>';
        }
    }
}

/**
 * Show author post with avatar
 */
function ad_mag_lite_author_avatar($ID, $span = false){
    $url  = get_author_posts_url($ID);
    if($span){
        $name = '<span>'.get_the_author_meta('display_name', $ID).'</span>';
    }else{
        $name = get_the_author_meta('display_name', $ID);
    }
    $img  = get_avatar($ID, 20, '', $name );

    echo '<a href="'.$url.'">
        <div class="entry-author">
            '.$img.$name.'
        </div>
    </a>';
}
