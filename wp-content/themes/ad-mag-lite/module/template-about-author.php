<?php 

if(is_page()){
    return;
}

$user_id = $post->post_author;
?>
    <div class="kopa-author clearfix">
        <a class="author-thumb" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar($user_id, 90, '', $name ); ?></a> 
        <div class="author-content clearfix">
            <h4 class="author-name"><?php _e('ABOUT THE AUTHOR', 'ad-mag-lite'); ?> <?php the_author_posts_link(); ?></h4>
            <p><?php the_author_meta( 'description' ); ?></p>
        </div>
    </div>
    <!-- kopa-author -->