<?php 
/**
 * Template Name: Page Right Sidebar
 */
get_header(); 
?>
    <?php ad_mag_lite_get_breadcrumb(); ?>
    <!--/end .breadcrumb-->

    <div id="main-content" class="mb-20">

        <div class="wrapper">

            <div class="row">
                <?php if(is_active_sidebar( 'right-sidebar' )) {
                    echo '<div class="kopa-main-col">';
                }else {
                    echo '<div class="col-md-12 col-sm-12 col-xs-12">';
                }
                ?>
                    <div class="kopa-bg-content">
                        <?php if(have_posts()) : while(have_posts()) : the_post() ?>
                            <div class="pd-20 kopa-entry-post">

                                <article class="entry-item">
                                    <h4 class="entry-title"><?php the_title(); ?></h4>

                                    <?php the_content(); ?>
                                    
                                </article> 

                                <div class="tubia">
                                    <?php 
                                        $args = array(
                                            'before'           => '',
                                            'after'            => '',
                                            'link_before'      => '<span>',
                                            'link_after'       => '</span>',
                                            'next_or_number'   => 'number',
                                            'nextpagelink'     => __( 'Next page','ad-mag-lite'),
                                            'previouspagelink' => __( 'Previous page','ad-mag-lite'),
                                            'pagelink'         => '%',
                                            'echo'             => 1
                                        );
                                        wp_link_pages( $args );
                                    ?>
                                </div>

                                <?php if(has_tag()) : ?>
                                    <div class="kopa-tag-box">
                                        <?php the_tags( '<span>'.esc_html__( 'Tags', 'ad-mag-lite' ).'</span> ', ' '); ?>
                                    </div>
                                    <!-- kopa-tag-box --> 
                                <?php endif; ?>

                                <?php get_template_part('module/template','about-author' ); ?>

                            </div>
                        <?php endwhile; endif; ?>
                    </div>

                    <?php 
                        if(comments_open()){
                            comments_template();
                        }
                    ?>
            
                </div>
                <!-- kopa-main-col -->

                <?php if(is_active_sidebar( 'right-sidebar' )) {
                    echo '<div class="sidebar">';
                    dynamic_sidebar( 'right-sidebar' );
                    echo '</div>';
                } 
                ?>

            </div>
            <!-- row --> 
        
        </div>
        <!-- wrapper -->

    </div>
    <!-- main-content -->
<?php get_footer(); ?>