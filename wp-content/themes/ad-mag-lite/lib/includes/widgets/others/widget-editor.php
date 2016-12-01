<?php

add_action( 'widgets_init', function(){
	register_widget( 'Ad_Mag_Lite_Editor' );
});

/**
 * Widget Editor
 */
class Ad_Mag_Lite_Editor extends WP_Widget {
    function __construct() {
        $widget_ops  = array('classname' => 'kopa-editor-widget', 'description' => __('Show user in role with avatar', 'ad-mag-lite'));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('Ad_Mag_Lite_Editor', __('(AdMag) Editor', 'ad-mag-lite'), $widget_ops, $control_ops);
    }

public function widget( $args, $instance ) {
        extract( $args );

        if ( isset( $instance['title'] ) ) {
            $title  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        } else {
            $title = '';
        }
        
        if ( isset( $instance['role'] ) ) {
            $role = $instance['role'];
        } else {
            $role = 'author';
        }
        
        
        if ( isset( $instance['number'] ) ) {
            $number = $instance['number'];
        } else {
            $number = 5;
        }

        echo wp_kses_post($before_widget);
        ?>  
            <?php if(!empty($title)) : ?>
                <h3 class="widget-title style2"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>

            <?php 
                $args = array(
                    'role'   => $role,
                    'number' => $number
                );
                $blogusers = get_users( $args );
            ?>

            <?php if(!empty($blogusers)) : ?>
                <ul class="clearfix">
                    <?php foreach ($blogusers as $bloguser) {
                        if(!empty($bloguser->data->user_url)) {
                            $url = $bloguser->data->user_url;
                        }else {
                            $url = get_author_posts_url($bloguser->data->ID);
                        }
                        echo '<li><a href="'.$url.'">'.get_avatar($bloguser->data->ID, 80, '', $bloguser->data->user_nicename ).'</a></li>';
                    }?>
                </ul>
            <?php else : ?>
                <p><?php echo __('No user in role', 'ad-mag-lite'); ?></p>
            <?php endif; ?>

        <?php
        echo wp_kses_post($after_widget);  
    }

    function form($instance) {
        $default = array(
            'title'  => '',
            'role'   => 'author',
            'number' => 5
        );
        $instance = wp_parse_args((array) $instance, $default);
        $title    = strip_tags($instance['title']);

        $form['role']   = $instance['role'];
        $form['number'] = esc_attr($instance['number']);
        ?>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'ad-mag-lite'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>

    <p>
        <label for="<?php echo esc_attr($this->get_field_id('role')); ?>"><?php _e('Role', 'ad-mag-lite'); ?>:</label>
        <select class="widefat" name="<?php echo esc_attr($this->get_field_name('role')); ?>" id="<?php echo esc_attr($this->get_field_id('service')); ?>">
            <option value="editor" <?php selected('editor', $form['role']); ?>><?php _e('Editor', 'ad-mag-lite'); ?></option>
            <option value="author" <?php selected('author', $form['role']); ?>><?php _e('Author', 'ad-mag-lite'); ?></option>
            <option value="contributor" <?php selected('contributor', $form['role']); ?>><?php _e('Contributor', 'ad-mag-lite'); ?></option>
            <option value="subscriber" <?php selected('subscriber', $form['role']); ?>><?php _e('Subscriber', 'ad-mag-lite'); ?></option>
        </select>
    </p>

    <p>
        <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number to show:', 'ad-mag-lite'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" value="<?php echo esc_attr($form['number']); ?>" />
    </p>

    <?php
    }

    function update($new_instance, $old_instance) {
        $instance            = $old_instance;
        $instance['title']  = strip_tags($new_instance['title']);
        $instance['role']   = strip_tags($new_instance['role']);
        $instance['number'] = strip_tags($new_instance['number']);

        return $instance;
    }
}