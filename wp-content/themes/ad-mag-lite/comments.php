<?php
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
    die(__('Please do not load this page directly. Thanks!', 'ad-mag-lite'));
}

// check if post is pwd protected
if ( post_password_required() )
    return;

    if ( have_comments() ) { ?>
    <div id="comments">
        <h3><?php comments_number(__('No Comment', 'ad-mag-lite'), __('1 Comment', 'ad-mag-lite'), __('% Comments', 'ad-mag-lite')); ?></h3>
        <ol class="comments-list clearfix">
            <?php
            wp_list_comments(array(
                'walker'       => null,
                'style'        => 'li',
                'callback'     => 'ad_mag_lite_comments_callback',
                'end-callback' => null,
                'type'         => 'all'
            ));
            ?>
        </ol>

        <?php
        // whether or not display paginate comments link
        $prev_comments_link = get_previous_comments_link();
        $next_comments_link = get_next_comments_link();

        if ( '' !== $prev_comments_link . $next_comments_link ) { ?>                
            <div class="pagination kopa-comment-pagination">
                <?php 
                $args = array(
                 'prev_text'    => __('Previous','ad-mag-lite'),
                 'next_text'    => __('Next','ad-mag-lite')
                );

                paginate_comments_links($args); ?>
            </div>
            <!-- pagination -->
        <?php } // endif ?>
    </div>
    <?php } elseif ( ! comments_open() && post_type_supports(get_post_type(), 'comments') ) {
        return;
    } // endif

    // Get comment form
    ad_mag_lite_comment_form();

/*
 * Comments call back function
 */
function ad_mag_lite_comments_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;

    if ( 'pingback' == get_comment_type() || 'trackback' == get_comment_type() ) { ?>

    <li id="comment-<?php echo comment_ID(); ?>" <?php comment_class( 'comment' ); ?>>
        <article class="comment-wrap clearfix">
            <div class="comment-avatar">
                <?php if ( get_comment_author_url() ) { ?>
                        <a href="<?php comment_author_url(); ?>">
                <?php } ?>

                <?php echo get_avatar( $comment->comment_author_email, 50 ); ?>

                <?php if ( get_comment_author_url() ) { ?>
                        </a>
                <?php } ?>
            </div>
            <div class="media-body clearfix">
                <header class="clearfix">
                    <div class="pull-left">
                        <h4><?php _e( 'Pingback', 'ad-mag-lite' ); ?></h4>
                        <div class="entry-meta">
                            <span class="entry-date"><i class="fa fa-clock-o"></i><?php comment_date( 'M j, Y' ); ?></span>
                        </div>
                    </div>
                    <div class="comment-button pull-right">
                        <?php if ( current_user_can( 'moderate_comments' ) ) {
                        edit_comment_link( __( 'Edit', 'ad-mag-lite' ) );
                        }?>
                    </div>
                </header>
                <p><a href="<?php if ( get_comment_author_url() ) { echo get_comment_author_url(); }?>" target="_blank" title="<?php _e('Pingback', 'ad-mag-lite');?>"><?php if ( get_comment_author_url() ) { echo get_comment_author_url(); }?></a></p>
            </div><!--comment-body -->
        </article>
    </li>

    <?php } elseif ( 'comment' == get_comment_type() ) { ?>

    <li id="comment-<?php echo comment_ID(); ?>" <?php comment_class( 'comment clearfix' ); ?> >
        <article class="comment-wrap clearfix">
            <div class="comment-avatar">
                <?php if ( get_comment_author_url() ) { ?>
                        <a href="<?php comment_author_url(); ?>">
                <?php } ?>

                <?php echo get_avatar( $comment->comment_author_email, 50 ); ?>

                <?php if ( get_comment_author_url() ) { ?>
                        </a>
                <?php } ?>
            </div>

            <div class="media-body clearfix">
                <header class="clearfix">
                    <div class="pull-left">
                        <h4><?php comment_author_link(); ?></h4>
                        <div class="entry-meta">
                            <span class="entry-date"><i class="fa fa-clock-o"></i><?php comment_date( 'M j, Y' ); ?></span>
                        </div>
                    </div>
                    <div class="comment-button pull-right">
                        <?php if ( current_user_can( 'moderate_comments' ) ) {
                        edit_comment_link( __( 'Edit', 'ad-mag-lite' ) );
                        echo '<span>&nbsp;/&nbsp;</span>';
                    } comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                    
                    </div>
                </header>
                <?php comment_text(); ?>
            </div><!--comment-body -->
        </article>
    

    <?php
    } // endif check comment type
}

function ad_mag_lite_comment_form($args = array(), $post_id = null) {
    if (null === $post_id)
        $post_id = get_the_ID();
    $commenter              = wp_get_current_commenter();
    $commeter_author        = esc_attr($commenter['comment_author']);
    $commenter_author_email = esc_attr($commenter['comment_author_email']);
    $commenter_author_url   = esc_attr($commenter['comment_author_url']);
    $user                   = wp_get_current_user();
    $user_identity          = $user->exists() ? $user->display_name : '';
    $args                   = wp_parse_args($args);
    if (!isset($args['format']))
        $args['format'] = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';
    $req      = get_option('require_name_email');
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = 'html5' === $args['format'];
    $fields   = array();

    $fields['author'] = '<div class="row">';
    $fields['author'].= '<div class="col-md-4 col-sm-4 col-xs-4">';
    $fields['author'].= '<p class="input-label">'.__('Name *','ad-mag-lite').'</p>';
    $fields['author'].= '<p class="input-block"><input id="comment_name" name="author" value="'. $commeter_author . '" type="text"></p>';
    $fields['author'].= '</div>';

    $fields['email'] = '<div class="col-md-4 col-sm-4 col-xs-4">';
    $fields['email'].= '<p class="input-label">'.__('Email *','ad-mag-lite').'</p>';
    $fields['email'].= '<p class="input-block"><input id="comment_email" name="email" value="'. $commenter_author_email . '"  type="email"></p>';
    $fields['email'].= '</div>';

    $fields['url'] = '<div class="col-md-4 col-sm-4 col-xs-4">';
    $fields['url'].= '<p class="input-label">'.__('Website','ad-mag-lite').'</p>';
    $fields['url'].= '<p class="input-block"><input id="comment_url" type="text" name="url" value="' . $commenter_author_url .'"></p>';
    $fields['url'].= '</div>';
    $fields['url'].= '</div>';

    if ( ! is_user_logged_in() ) {
        $comment_field = '<p class="textarea-block">';
        $comment_field.= '<textarea value="" name="comment" id="comment_message" cols="88" rows="6"></textarea>';
        $comment_field.= '</p>';
    } else {
        $comment_field = '<p class="textarea-block">';
        $comment_field.= '<textarea value="" name="comment" id="comment_message" cols="88" rows="6"></textarea>';
        $comment_field.= '</p>';
    }

    $fields = apply_filters('comment_form_default_fields', $fields);

    $defaults = array(
        'fields'               => $fields,
        'comment_field'        => $comment_field,
        'must_log_in'          => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', 'ad-mag-lite'), wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
        'logged_in_as'         => '<p class="logged-in-as">' . sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'ad-mag-lite'), get_edit_user_link(), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
        'comment_notes_before' => __('Your email address will not be published. Required fields are marked *', 'ad-mag-lite'),
        'comment_notes_after'  => '',
        'id_form'              => 'comments-form',
        'id_submit'            => 'submit-contact',
        'title_reply'          => __('POST YOUR COMMENTS', 'ad-mag-lite'),
        'title_reply_to'       => __('POST YOUR COMMENTS TO %s', 'ad-mag-lite'),
        'cancel_reply_link'    => __('(Cancel)', 'ad-mag-lite'),
        'label_submit'         => __('Post Comment', 'ad-mag-lite'),
        'format'               => 'xhtml',
    );
    $args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));
    ?>
    <?php if (comments_open($post_id)) : ?>
        <?php
        do_action('comment_form_before');
        ?>
        <div class="widget kopa-comment-form-widget">            
            <h3 class="widget-title style3">
                <?php comment_form_title($args['title_reply'], $args['title_reply_to']); ?>
                <?php cancel_comment_reply_link($args['cancel_reply_link']); ?>
            </h3>  
            <div class="pd-20"> 
                <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
                    <?php echo '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', 'ad-mag-lite'), wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>'; ?>
                    <?php
                    do_action('comment_form_must_log_in_after');
                    ?>
                <?php else : ?> 
                    <div class="comment-box">           
                        <form action="<?php echo site_url('/wp-comments-post.php'); ?>" method="post" id="<?php echo esc_attr($args['id_form']); ?>" class="clearfix" <?php echo esc_attr($html5) ? ' novalidate' : ''; ?>>                    
                            <?php
                            do_action('comment_form_top');
                            ?>
                            <?php if (is_user_logged_in()) : ?>
                                <?php
                                echo apply_filters('comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity);
                                ?>
                                <?php
                                do_action('comment_form_logged_in_after', $commenter, $user_identity);
                                ?>
                            <?php else : ?>                        
                                <?php
                                echo '<p><i>'.$args['comment_notes_before'].'</i></p>';
                                do_action('comment_form_before_fields');
                                foreach ((array) $args['fields'] as $name => $field) {
                                    echo apply_filters("comment_form_field_{$name}", $field) . "\n";
                                }
                                do_action('comment_form_after_fields');
                                ?>
                            <?php endif; ?>
                            <?php
                            echo apply_filters('comment_form_field_comment', $args['comment_field']);
                            ?>
                            <?php echo esc_html($args['comment_notes_after']); ?>

                            <p class="comment-button clearfix">  
                                <span> 
                                    <input type="submit" name="submit"  value="<?php echo esc_attr($args['label_submit']); ?>" id="<?php echo esc_attr($args['id_submit']); ?>" class="input-submit">
                                </span>                                                                                 
                                <?php comment_id_fields($post_id); ?>                                                                     
                            </p>

                            <?php
                            do_action('comment_form', $post_id);
                            ?>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        do_action('comment_form_after');
    else :
        do_action('comment_form_comments_closed');
    endif;
}
