<?php
/**
 * Description: A page template with the right column for WooCommerce
 * @package lavish
 * @since 1.0.0
 */
get_header(); ?>
<section id="la-content-area" class="la-contents" role="main">
    <div class="container">
        <div class="row">
            <?php
            	woocommerce_content();
            ?>
        </div>  
    </div>
</section>
<?php get_footer();