<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" /> 
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="kopa-header">

        <div class="kopa-header-top">  

            <div class="wrapper">

                <?php ad_mag_lite_top_headline(); ?>

                <div class="header-top-right">
                    <?php if(has_nav_menu('top-menu')) : ?>
                    <nav class="top-nav">
                        <?php
                        $args = array(
                            'theme_location' => 'top-menu',
                            'container'      => false,
                            'menu_class'     => 'top-menu clearfix',
                            'depth'          => -1
                            );

                        wp_nav_menu( $args );
                        ?>
                    </nav>
                    <!-- top-nav -->

                    <nav class="top-nav-mobile">
                        <a class="pull"><i class="fa fa-bars"></i></a>
                        <?php
                        $args = array(
                            'theme_location' => 'top-menu',
                            'container'      => false,
                            'menu_class'     => 'top-menu-mobile clearfix',
                            'depth'          => -1
                            );

                        wp_nav_menu( $args );
                        ?>   
                    </nav>
                    <!-- top-nav -->
                <?php endif; ?>

            </div>
            <!-- header-top-right -->   

        </div>  
        <!-- wrapper -->

    </div>
    <!-- kopa-header-top -->

    <div class="kopa-header-middle">

        <div class="wrapper">
            <?php
            if(has_custom_logo()) : 
                ?>
            <div class="kopa-logo">
                <?php ad_mag_lite_the_custom_logo(); ?>
            </div>
            <!-- logo -->
        <?php else: ?>
        <div class="kopa-logo">
            <?php if(is_home()) : ?>
            <h1 class="site-title"><a href="<?php echo esc_url( home_url('/') ); ?>"><?php echo bloginfo('name'); ?></a></h1>
            <?php else: ?>
            <h2 class="site-title"><a href="<?php echo esc_url( home_url('/') ); ?>"><?php echo bloginfo('name'); ?></a></h2>
            <?php endif; ?>
        </div>
        <!-- logo -->
    <?php endif; ?>

    <?php ad_mag_lite_social(); ?>

</div>
<!-- wrapper -->

</div>
<!-- kopa-header-middle -->

<div class="kopa-header-bottom">

    <div class="wrapper">

        <div class="header-bottom-wrap">
            <?php if(has_nav_menu('main-menu')) : ?>
            <nav class="kopa-main-nav">
                <?php 
                $args = array(
                    'theme_location' => 'main-menu',
                    'container'      => false,
                    'menu_class'     => 'main-menu sf-menu'
                    );

                wp_nav_menu( $args );
                ?>               
            </nav>
            <!--/end main-nav-->

            <nav class="main-nav-mobile">
                <a class="pull"><?php _e('Menu', 'ad-mag-lite'); ?><i class="fa fa-caret-down"></i></a>
                <?php 
                $args = array(
                    'theme_location' => 'main-menu',
                    'container'      => false,
                    'menu_class'     => 'main-menu-mobile'
                    );

                wp_nav_menu( $args );
                ?>             
            </nav>
            <!--/end main-nav-->
        <?php endif; ?>

        <?php get_search_form();  ?>

    </div>
    <!-- header-bottom-wrap -->

</div>
<!-- wrapper -->

</div>
<!-- kopa-header-bottom -->

</header>
    <!-- kopa-page-header -->