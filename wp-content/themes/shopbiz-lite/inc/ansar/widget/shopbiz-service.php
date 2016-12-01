<?php 
add_action('widgets_init','shopbiz_service_widget');
function shopbiz_service_widget(){
	
	return register_widget('shopbiz_service_widget');
}

class shopbiz_service_widget extends WP_Widget{
	
	function __construct() {
		parent::__construct(
			'shopbiz_service_widget', // Base ID
			__('shopbiz - Service Widget', 'shopbiz'), // Name
			array( 'description' => __( 'Service Section Widget', 'shopbiz'), ) // Args
		);
	}

    function widget($args, $instance) {

        extract($args);

        echo $before_widget;
		$service_page=(isset($instance['service_page'])?$instance['service_page']:'');
		
		if(($instance['service_page']) !=null) {
		$page= get_post($instance['service_page']);
		$post_thumbnail_id = get_post_thumbnail_id($service_page);
		$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
		?>

        <div class="ta-service">
        <?php if($post_thumbnail_url) {?>
        	<?php // Check for displaying feature image
				echo '<img src="'. wp_get_attachment_url( get_post_thumbnail_id($instance['service_page']) ) .'" />'; ?>
        	<?php } ?>
			<div class="ta-service-inner">
				<?php echo '<h3 class="widgettitle">'. $page->post_title .'</h3>'; ?>
            	<?php if($page->post_content) echo '<p>'.$page->post_content. '</p>'; // check for the page content ?>
            </div>
         </div>
        <?php }
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {

        $instance = $old_instance;
		$instance['service_page'] = ( ! empty( $new_instance['service_page'] ) ) ? $new_instance['service_page'] : '';
	    return $instance;

    }

    function form($instance) {

        ?>
        <table>
        	<tr>
        	<p>
			<label for="<?php echo $this->get_field_id( 'service_page' ); ?>"><?php _e( 'Select Pages:','shopbiz' ); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'service_page' ); ?>" name="<?php echo $this->get_field_name( 'service_page' ); ?>">
				<option value>--Select--</option>
				<?php
					$service_page = $instance['service_page'];
					$pages = get_pages($service_page); 				
					foreach ( $pages as $page ) {
						$option = '<option value="' . $page->ID . '" ';
						$option .= ( $page->ID == $service_page ) ? 'selected="selected"' : '';
						$option .= '>';
						$option .= $page->post_title;
						$option .= '</option>';
						echo $option;
					}
				?>
						
			</select>
			<br/>
			</p>
			</tr>
		</table>
    <?php
    }

}