<?php

add_action( 'widgets_init', function(){
	register_widget( 'Ad_Mag_Lite_Follow' );
});

/**
 * Widget Follow
 */
class Ad_Mag_Lite_Follow extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'kopa-follow-widget', 'description' => __('Display social link', 'ad-mag-lite'));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('Ad_Mag_Lite_Follow', __('(AdMag) Follow', 'ad-mag-lite'), $widget_ops, $control_ops);
    }

public function widget( $args, $instance ) {
    
    ob_start();
    extract( $args );

    if ( isset( $instance['title'] ) ) {
        $title  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
    } else {
        $title = '';
    }

    $social_links = array(
        'social_facebook'  => array(
            'url'     => '',
            'icon'    => 'fa-facebook',
            'display' => false,
            'name'    => 'Facebook'
        ),
        'social_twitter'   => array(
            'url'     => '',
            'icon'    => 'fa-twitter',
            'display' => false,
            'name'    => 'Twitter'
        ),
        'social_google_plus'     => array(
            'url'     => '',
            'icon'    => 'fa-google-plus',
            'display' => false,
            'name'    => 'Google +'
        ),
        'social_linkedin'     => array(
            'url'     => '',
            'icon'    => 'fa-linkedin',
            'display' => false,
            'name'    => 'Linkedin'
        ),
        'social_tumblr'     => array(
            'url'     => '',
            'icon'    => 'fa-tumblr',
            'display' => false,
            'name'    => 'Tumblr'
        ),
        'social_pinterest'     => array(
            'url'     => '',
            'icon'    => 'fa-pinterest',
            'display' => false,
            'name'    => 'Pinterest'
        ),
        'social_rss'  => array(
            'url'     => '',
            'icon'    => 'fa-rss',
            'display' => false,
            'name'    => 'RSS'
        ),
    );
    $display = false;
    foreach( $social_links as $social_name => $social_atts ) {
        $option_name        = $social_name;
        $social_atts['url'] = get_theme_mod( $option_name, '' );

        if ( 'social_rss' == $social_name ) {
            if ( empty( $social_atts['url'] ) ) {
                $social_atts['url']     = get_bloginfo('rss2_url');
                $social_atts['display'] = true;
                $display                = true;
            } elseif ( $social_atts['url'] != 'HIDE' ) {
                $social_atts['url']     = esc_url( $social_atts['url'] );
                $social_atts['display'] = true;
            }
        } else {
            $social_atts['url'] = esc_url( $social_atts['url'] );
            if ( !empty( $social_atts['url'] ) ) { 
                $social_atts['display'] = true; 
                $display                = true;
            }
        }

        $social_links[ $social_name ] = $social_atts;
    }

    $target = '_blank';

    echo wp_kses_post($before_widget);

    ?>
    
        <div class="widget kopa-follow-widget">
            <?php if(!empty($title)) : ?>
                <h3 class="widget-title style2"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
            <?php if($display) : ?>
                <ul class="clearfix">
                    <?php foreach ( $social_links as $social_name => $social_atts) { ?>
                        <?php if ( $social_atts['display'] ) { ?>
                            <li>
                                <a href="<?php echo esc_url($social_atts['url']); ?>" target="<?php echo esc_attr($target); ?>" rel="nofollow">
                                    <i class="fa <?php echo esc_attr($social_atts['icon']); ?>"></i><span><?php echo esc_html($social_atts['name']); ?></span>
                                </a>
                            </li>
                        <?php } // endif ?>
                    <?php } // endforeach ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php

    echo wp_kses_post($after_widget); 
}

    function form($instance) {
        $default = array(
            'title'  => ''
        );
        $instance = wp_parse_args((array) $instance, $default);
        $title    = strip_tags($instance['title']);
        ?>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'ad-mag-lite'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
    <?php
    }

    function update($new_instance, $old_instance) {
        $instance          = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }
}