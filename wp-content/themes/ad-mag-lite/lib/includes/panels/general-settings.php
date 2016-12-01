<?php

function ad_mag_lite_init_options($options){
    $options['sections'][] = array(
        'id'    => 'ad_mag_opt_general',
        'title' => __('General Settings', 'ad-mag-lite'));

    $options['settings'][] = array(
        'settings'    => 'sticky_menu',
        'label'       => __('Sticky Menu', 'ad-mag-lite'),
        'description' => '',
        'default'     => '1',
        'type'        => 'checkbox',
        'section'     => 'ad_mag_opt_general',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings'    => 'social_facebook',
        'label'       => __('Socials', 'ad-mag-lite'),
        'description' => __('Facebook', 'ad-mag-lite'),
        'default'     => '',
        'type'        => 'text',
        'section'     => 'ad_mag_opt_general',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings'    => 'social_twitter',
        'label'       => '',
        'description' => __('Twitter', 'ad-mag-lite'),
        'default'     => '',
        'type'        => 'text',
        'section'     => 'ad_mag_opt_general',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings'    => 'social_google_plus',
        'label'       => '',
        'description' => __('Google +', 'ad-mag-lite'),
        'default'     => '',
        'type'        => 'text',
        'section'     => 'ad_mag_opt_general',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings'    => 'social_linkedin',
        'label'       => '',
        'description' => __('Linkedin', 'ad-mag-lite'),
        'default'     => '',
        'type'        => 'text',
        'section'     => 'ad_mag_opt_general',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings'    => 'social_tumblr',
        'label'       => '',
        'description' => __('Tumblr', 'ad-mag-lite'),
        'default'     => '',
        'type'        => 'text',
        'section'     => 'ad_mag_opt_general',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings'    => 'social_pinterest',
        'label'       => '',
        'description' => __('Pinterest', 'ad-mag-lite'),
        'default'     => '',
        'type'        => 'text',
        'section'     => 'ad_mag_opt_general',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings'    => 'social_rss',
        'label'       => '',
        'description' => __('RSS (enter HIDE if want to hide)', 'ad-mag-lite'),
        'default'     => '#',
        'type'        => 'text',
        'section'     => 'ad_mag_opt_general',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings'    => 'copyright',
        'label'       => __('Copyright', 'ad-mag-lite'),
        'description' => __('Your copyright information on footer.', 'ad-mag-lite'),
        'default'     => '',
        'type'        => 'textarea',
        'section'     => 'ad_mag_opt_general',
        'transport'   => 'refresh');

    $options['settings'][] = array(
        'settings' => 'blog-layout',
        'label'    => __('Blog layout', 'ad-mag-lite'),        
        'default'  => '1',
        'type'     => 'select',
        'choices'  => array(
            '1' => __('Blog-1', 'ad-mag-lite'),
            '2' => __('Blog-2', 'ad-mag-lite'),
            '3' => __('Blog-3', 'ad-mag-lite'),
            '4' => __('Blog-4', 'ad-mag-lite')
            ),
        'section'     => 'ad_mag_opt_general',
        'transport'   => 'refresh'); 

    $options['settings'][] = array(
        'settings'    => 'custom_css',
        'label'       => __('Custom css', 'ad-mag-lite'),
        'description' => __('Your custom css', 'ad-mag-lite'),
        'default'     => '',
        'type'        => 'textarea',
        'section'     => 'ad_mag_opt_general',
        'transport'   => 'refresh');

    return $options;
}