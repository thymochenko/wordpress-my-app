<?php get_header(); ?>
    <?php ad_mag_lite_get_breadcrumb(); ?>
    <!--/end .breadcrumb-->

    <div id="main-content" class="mb-20">

        <div class="wrapper">

            <section class="error-404 clearfix">
                <div class="left-col">
                    <p><?php _e('404', 'ad-mag-lite'); ?></p>
                </div><!--left-col-->
                <div class="right-col">
                    <h1><?php _e('Page not found...', 'ad-mag-lite'); ?></h1>
                    <p><?php _e('We\'re sorry, but we can\'t find the page you were looking for. It\'s probably some thing we\'ve done wrong but now we know about it we\'ll try to fix it. In the meantime, try one of this options:', 'ad-mag-lite'); ?></p>
                    <ul class="arrow-list">
                        <li><a href="javascript: history.go(-1)"><?php _e('Go back to previous page', 'ad-mag-lite'); ?></a></li>
                        <li><a href="<?php echo esc_url ( home_url('/') ); ?>"><?php _e('Go to homepage', 'ad-mag-lite'); ?></a></li>
                    </ul>
                </div><!--right-col-->
            </section>
        
        </div>
        <!-- wrapper -->

    </div>

<?php get_footer(); ?>