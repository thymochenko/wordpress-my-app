<?php 

?>
<div id="bottom-sidebar">

    <div class="wrapper">

        <div class="bottom-area-1">
            <?php if(has_nav_menu('bottom-menu')) : ?>
            <nav class="bottom-nav">
                <?php 
                $args = array(
                    'theme_location' => 'bottom-menu',
                    'menu'           => '',
                    'container'      => false,
                    'menu_class'     => 'bottom-menu',
                    'depth'          => 0
                    );

                wp_nav_menu( $args );
                ?>
            </nav>
            <!--/end bottom-nav-->
        <?php endif; ?>

        <a href="#" class="scrollup"><span class="fa fa-chevron-up"></span></a>

    </div>
    <!-- bottom-area-1 -->

<div class="bottom-area-2">
    <?php
    if(is_active_sidebar('footer-1-sidebar')){
        echo '<div class="widget-area-1">';
        dynamic_sidebar('footer-1-sidebar');
        echo '</div><!-- widget-area-1 -->';
    } ?>

<?php
if(is_active_sidebar('footer-2-sidebar')){
    echo '<div class="widget-area-2">';
    dynamic_sidebar('footer-2-sidebar');
    echo '</div>';
}
?>

<?php
if(is_active_sidebar('footer-3-sidebar')){
    echo '<div class="widget-area-3">';
    dynamic_sidebar('footer-3-sidebar');
    echo '</div>';
}
?>

<?php
if(is_active_sidebar('footer-4-sidebar')){
    echo '<div class="widget-area-4">';
    dynamic_sidebar('footer-4-sidebar');
    echo '</div>';
}
?>

</div>
<!-- bottom-area-2 -->

</div>
<!-- wrapper -->

</div>
<!-- bottom-sidebar -->
<?php 
$copyright = get_theme_mod('copyright');
if(!empty($copyright)) : ?>
<footer id="kopa-footer">
    <div class="wrapper clearfix">
        <p id="copyright" class=""><?php echo wp_kses_post($copyright); ?></p>
    </div>
    <!-- wrapper -->
</footer>
<!-- kopa-footer -->
<?php endif; ?>

<?php wp_footer(); ?>

</body>

</html>