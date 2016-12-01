<?php

add_action( 'widgets_init', function(){
	register_widget( 'Ad_Mag_Lite_Comments' );
});

/**
 * Widget Comments
 */
class Ad_Mag_Lite_Comments extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'kopa-comment-widget', 'description' => __('Show recent comments', 'ad-mag-lite'));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('Ad_Mag_Lite_Comments', __('(AdMag) Comments', 'ad-mag-lite'), $widget_ops, $control_ops);
    }

public function widget( $args, $instance ) {
        extract( $args );

        if ( isset( $instance['title'] ) ) {
            $title  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        } else {
            $title = '';
        }
        if ( isset( $instance['number'] ) ) {
            $number = $instance['number'];
        } else {
            $number = 5;
        }

        $comments = get_comments( apply_filters( 'widget_comments_args', array(
            'number'      => $number,
            'status'      => 'approve',
            'post_status' => 'publish'
        ) ) );

        echo wp_kses_post($before_widget);
        ?>  
            <?php if(!empty($title)) : ?>
                <h3 class="widget-title style3"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
            <div class="pd-20">
                <ul class="clearfix">
                    <?php if ( $comments ) : ?>
                        
                        <?php 
                            // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
                            $post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
                            _prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

                            foreach ( (array) $comments as $comment) : 
                        ?>
                            <li>
                                <article class="entry-item">
                                    <div class="cmt-content">
                                        <p><?php echo wp_kses_post($comment->comment_content); ?></p>
                                    </div>
                                    <p>by <a href="<?php echo esc_url($comment->comment_author_url); ?>"><?php echo esc_html($comment->comment_author); ?></a> <?php echo esc_html($comment->post_title); ?></p>
                                </article>
                            </li>
                        <?php endforeach;
                        ?>
                    <?php endif; ?>
                </ul>
            </div>
        <?php

        echo wp_kses_post($after_widget);
    }

    function form($instance) {
        $default = array(
            'title'  => '',
            'number' => 5
        );
        $instance       = wp_parse_args((array) $instance, $default);
        $title          = strip_tags($instance['title']);
        $form['number'] = esc_attr($instance['number']);
        ?>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'ad-mag-lite'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>

    <p>
        <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number of comments:', 'ad-mag-lite'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" value="<?php echo esc_attr($form['number']); ?>" />
    </p>

    <?php
    }

    function update($new_instance, $old_instance) {
        $instance           = $old_instance;
        $instance['title']  = strip_tags($new_instance['title']);
        $instance['number'] = strip_tags($new_instance['number']);

        return $instance;
    }
}