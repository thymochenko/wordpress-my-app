<?php
/**
 * Defines customizer options
 *
 */
function avata_customizer_options() {
	global $avata_social_icons,$avata_sidebars,$avata_default_options , $avata_homepage_sections;

  // Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = __( 'Select a page:', 'avata' );
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	
	
 $choices =  array( 
            '1'   => __( 'Yes', 'avata' ),
            '0' => __( 'No', 'avata' )
 
        );
 
 $choices_reverse =  array( 
           '0'=> __( 'No', 'avata' ),
            '1' => __( 'Yes', 'avata' )
         
        );

  $align =  array( 
          
          'left' => __( 'Left', 'avata' ),
          'right' => __( 'Right', 'avata' ),
          'center'  => __( 'Center', 'avata' )         
        );
  $repeat = array( 
          
          'repeat' => __( 'repeat', 'avata' ),
          'repeat-x'  => __( 'repeat-x', 'avata' ),
          'repeat-y' => __( 'repeat-y', 'avata' ),
          'no-repeat'  => __( 'no-repeat', 'avata' )
          
        );
  
  $position =  array( 
          
           'top left' => __( 'Top Left', 'avata' ),
           'top center' => __( 'Top Center', 'avata' ),
           'top right' => __( 'Top Right', 'avata' ),
           'center left' => __( 'Center Left', 'avata' ),
           'center center'  => __( 'Center Center', 'avata' ),
           'center right' => __( 'Center Right', 'avata' ),
           'bottom left'  => __( 'Bottom Left', 'avata' ),
           'bottom center'  => __( 'Bottom Center', 'avata' ),
           'bottom right' => __( 'Bottom Right', 'avata' )
            
        );
  
  $opacity   =  array_combine(range(0.1,1,0.1), range(0.1,1,0.1));
  $font_size =  array_combine(range(1,100,1), range(1,100,1));
  
  
  $avata_social_icons = array(
		  array('title'=>'Facebook','icon' => 'facebook', 'link'=>'#'),
		  array ('title'=>'Twitter','icon' => 'twitter', 'link'=>'#'), 
		  array('title'=>'LinkedIn','icon' => 'linkedin', 'link'=>'#'),
		  array  ('title'=>'YouTube','icon' => 'youtube', 'link'=>'#'),
		  array('title'=>'Skype','icon' => 'skype', 'link'=>'#'),
		  array ('title'=>'Pinterest','icon' => 'pinterest', 'link'=>'#'),
		  array('title'=>'Google+','icon' => 'google-plus', 'link'=>'#'),
		  array('title'=>'Email','icon' => 'envelope', 'link'=>'#'),
		  array ('title'=>'RSS','icon' => 'rss', 'link'=>'#')
        );
  $target = array(
				  '_blank' => __( 'Open in new window', 'avata' ),
				  '_self' => __( 'Open in same window', 'avata' )
				  );
  
  
	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Stores all the panels to be added
	$panels = array();

	// Adds the sections to the $options array
	$options['sections'] = $sections;
	
 ##### Home Page #####
	
		$avata_homepage_sections = array(
							  'hero' => __( 'Section - Hero', 'avata' ),
							  'features' => __( 'Section - Features', 'avata' ),
							  'content_image' => __( 'Section - ( Content - Image )', 'avata' ),
							  'image_content' => __( 'Section - ( Image - Content )', 'avata' ),
							  'promo' => __( 'Section - Promo', 'avata' ),
							  );
	
	$panel = 'avata-home-page';

	$panels[] = array(
		'id' => $panel,
		'title' => __( 'Home Page', 'avata' ),
		'priority' => '1'
	);
	

	// Section Banner
	$section = 'avata-section-hero';
	
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Section - Hero', 'avata' ),
		'priority' => '10',
		'panel' => $panel
	);
  $options['avata_section_hero_enable'] = array(
		'id' => 'avata_section_hero_enable',
		'label' => __( 'Enable Section', 'avata' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '1',
	);	
  
  $options['avata_section_hero_content_mode'] = array(
		'id' => 'avata_section_hero_content_mode',
		'label' => __( 'Select Content Mode', 'avata' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => array('0'=>__( 'Default', 'avata' ),'1'=>__( 'Custom', 'avata' )),
		'default' => '0',
	);
  
  $options['avata_section_hero_color'] = array(
		'id' => 'avata_section_hero_color',
		'label'   => __( 'Color', 'avata' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#ffffff',
		'description' => __( 'Set color for this section.', 'avata' )
	);
  
  $options['avata_section_hero_background_color'] = array(
		'id' => 'avata_section_hero_background_color',
		'label'   => __( 'Background Color', 'avata' ),
		'section' => $section,
		'type'    => 'color',
		'description' => __( 'Set background color for this section.', 'avata' )
	);
	
	$options['avata_section_hero_background_image'] = array(
		'id' => 'avata_section_hero_background_image',
		'label'   => __( 'Background Image', 'avata' ),
		'section' => $section,
		'type'    => 'upload',
		'description' => __( 'Upload background image for this section.', 'avata' )
	);
	
	$options['avata_section_hero_top_padding'] = array(
		'id' => 'avata_section_hero_top_padding',
		'label' => __( 'Section Top Padding', 'avata' ),
		'description' => __( 'In pixels, ex: 10px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '0',
	);
	
	$options['avata_section_hero_bottom_padding'] = array(
		'id' => 'avata_section_hero_bottom_padding',
		'label' => __( 'Section Bottom Padding', 'avata' ),
		'description' => __( 'In pixels, ex: 10px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '0',
	);
	$options['avata_section_hero_min_height'] = array(
		'id' => 'avata_section_hero_min_height',
		'label' => __( 'Section Min Height', 'avata' ),
		'description' => __( 'In pixels, ex: 500px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '36.5rem',
	);
	
  $options['avata_section_hero_page'] = array(
		'id' => 'avata_section_hero_page',
		'label' => __( 'Select Hero Page', 'avata' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $options_pages,
	);
  
  $options['avata_section_hero_bottom_img'] = array(
		'id' => 'avata_section_hero_bottom_img',
		'label' => __( 'Bottom Image?', 'avata' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '1',
	);	
  
  
   $options['avata_section_hero_custom'] = array(
		'id' => 'avata_section_hero_custom',
		'label' => __( 'Custom Content', 'avata' ),
		
		'section' => $section,
		'type'    => 'select',
		'choices' => $options_pages,
		
	);
   
  
$options['avata_section_hero_id'] = array(
		'id' => 'avata_section_hero_id',
		'label' => __( 'Section ID', 'avata' ),
		
		'section' => $section,
		'type'    => 'text',
		'default' => 'section-hero',
	);
		
 
	
	// Section Features
	$section = 'avata-section-features';
	
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Section - Features', 'avata' ),
		'priority' => '10',
		
		'panel' => $panel
	);
  $options['avata_section_features_enable'] = array(
		'id' => 'avata_section_features_enable',
		'label' => __( 'Enable Section', 'avata' ),
		
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '1',
	);	
  $options['avata_section_features_color'] = array(
		'id' => 'avata_section_features_color',
		'label'   => __( 'Color', 'avata' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#545457',
		'description' => __( 'Set color for this section.', 'avata' )
	);
  
  $options['avata_section_features_background_color'] = array(
		'id' => 'avata_section_features_background_color',
		'label'   => __( 'Background Color', 'avata' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#f3f3f4',
		'description' => __( 'Set background color for this section.', 'avata' )
	);
	
	$options['avata_section_features_background_image'] = array(
		'id' => 'avata_section_features_background_image',
		'label'   => __( 'Background Image', 'avata' ),
		'section' => $section,
		'type'    => 'upload',
		
		'description' => __( 'Upload background image for this section.', 'avata' )
	);
	
	$options['avata_section_features_top_padding'] = array(
		'id' => 'avata_section_features_top_padding',
		'label' => __( 'Section Top Padding', 'avata' ),
		'description' => __( 'In pixels, ex: 10px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '6.5rem',
	);
	
	$options['avata_section_features_bottom_padding'] = array(
		'id' => 'avata_section_features_bottom_padding',
		'label' => __( 'Section Bottom Padding', 'avata' ),
		'description' => __( 'In pixels, ex: 10px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '6.5rem',
	);
	$options['avata_section_features_min_height'] = array(
		'id' => 'avata_section_features_min_height',
		'label' => __( 'Section Min Height', 'avata' ),
		'description' => __( 'In pixels, ex: 500px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '30.5rem',
	);
	
  $options['avata_section_features_page'] = array(
		'id' => 'avata_section_features_page',
		'label' => __( 'Select Features Page', 'avata' ),
		
		'section' => $section,
		'type'    => 'select',
		'choices' => $options_pages,
		
	);	
  
  for( $i=0;$i < 6;$i++ ){
		$j = $i+1;
		$options['avata_section_features_icon_'.$i] = array(
		'id' => 'avata_section_features_icon_'.$i,
		'label' => sprintf(__( 'Font Awesome Icon %d', 'avata' ),$j),
		
		'section' => $section,
		'type'    => 'text',
		
	);
		
		$options['avata_section_features_image_'.$i] = array(
		'id' => 'avata_section_features_image_'.$i,
		'label' => sprintf(__( 'Upload Icon %d', 'avata' ),$j),
		
		'section' => $section,
		'type'    => 'upload',
		
	);
		
		$options['avata_section_features_page_'.$i] = array(
		'id' => 'avata_section_features_page_'.$i,
		'label' => sprintf(__( 'Feature Box Content %d', 'avata' ),$j),
		'description'   => __( 'Page excerpt content.', 'avata' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $options_pages,
		
	);
		
	$options['avata_section_features_link_'.$i] = array(
		'id' => 'avata_section_features_link_'.$i,
		'label' => sprintf(__( 'Enable Title Link %d', 'avata' ),$j),
		
		'section' => $section,
		'type'    => 'checkbox',
		
	);

	$options['avata_section_features_target_'.$i] = array(
		'id' => 'avata_section_features_target_'.$i,
		'label' => sprintf(__( 'Link Target %d', 'avata' ),$j),
		
		'section' => $section,
		'type'    => 'select',
		'choices' => $target,
		'default' => '_blank',
	);
		
		
		}
		
	$options['avata_section_features_id'] = array(
		'id' => 'avata_section_features_id',
		'label' => __( 'Section ID', 'avata' ),
		
		'section' => $section,
		'type'    => 'text',
		'default' => 'section-features',
	);
	
	// Section Content Image
	$section = 'avata-section-content-image';
	
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Section - ( Content - Image )', 'avata' ),
		'priority' => '10',
		
		'panel' => $panel
	);
  $options['avata_section_content_image_enable'] = array(
		'id' => 'avata_section_content_image_enable',
		'label' => __( 'Enable Section', 'avata' ),
		
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '1',
	);	
  $options['avata_section_content_image_color'] = array(
		'id' => 'avata_section_content_image_color',
		'label'   => __( 'Color', 'avata' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#545457',
		'description' => __( 'Set color for this section.', 'avata' )
	);
  
  $options['avata_section_content_image_background_color'] = array(
		'id' => 'avata_section_content_image_background_color',
		'label'   => __( 'Background Color', 'avata' ),
		'section' => $section,
		'type'    => 'color',
		
		'description' => __( 'Set background color for this section.', 'avata' )
	);
	
	$options['avata_section_content_image_background_image'] = array(
		'id' => 'avata_section_content_image_background_image',
		'label'   => __( 'Background Image', 'avata' ),
		'section' => $section,
		'type'    => 'upload',
		
		'description' => __( 'Upload background image for this section.', 'avata' )
	);
	
	$options['avata_section_content_image_background_repeat'] = array(
		'id' => 'avata_section_content_image_background_repeat',
		'label'   => __( 'Background Repeat', 'avata' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $repeat,
		'default' => 'no-repeat',
		
	);
	
	$options['avata_section_content_image_background_full'] = array(
		'id' => 'avata_section_content_image_background_full',
		'label'   => __( 'Background Image 100% Width', 'avata' ),
		'section' => $section,
		'type'    => 'checkbox',
		
		'default' => '1',
		
	);
	
	$options['avata_section_content_image_top_padding'] = array(
		'id' => 'avata_section_content_image_top_padding',
		'label' => __( 'Section Top Padding', 'avata' ),
		'description' => __( 'In pixels, ex: 10px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '6.5rem',
	);
	
	$options['avata_section_content_image_bottom_padding'] = array(
		'id' => 'avata_section_content_image_bottom_padding',
		'label' => __( 'Section Bottom Padding', 'avata' ),
		'description' => __( 'In pixels, ex: 10px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '0',
	);
	
	$options['avata_section_content_image_min_height'] = array(
		'id' => 'avata_section_content_image_min_height',
		'label' => __( 'Section Min Height', 'avata' ),
		'description' => __( 'In pixels, ex: 500px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '30.5rem',
	);
	
  $options['avata_section_content_image_page'] = array(
		'id' => 'avata_section_content_image_page',
		'label' => __( 'Select Page', 'avata' ),
		
		'section' => $section,
		'type'    => 'select',
		'choices' => $options_pages,
		
	);
  $options['avata_section_content_image_bottom'] = array(
		'id' => 'avata_section_content_image_bottom',
		'label' => __( 'Bottom Image?', 'avata' ),
		
		'section' => $section,
		'type'    => 'checkbox',
		'choices' => '',
		'default' => '1',
	);		
  $options['avata_section_content_image_id'] = array(
		'id' => 'avata_section_content_image_id',
		'label' => __( 'Section ID', 'avata' ),
		
		'section' => $section,
		'type'    => 'text',
		'default' => 'section-content-image',
	);
	
  // Section Image Content 
	$section = 'avata-section-image-content';
	
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Section - ( Image - Content )', 'avata' ),
		'priority' => '10',
		
		'panel' => $panel
	);
  $options['avata_section_image_content_enable'] = array(
		'id' => 'avata_section_image_content_enable',
		'label' => __( 'Enable Section', 'avata' ),
		
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '1',
	);	
  $options['avata_section_image_content_color'] = array(
		'id' => 'avata_section_image_content_color',
		'label'   => __( 'Color', 'avata' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#ffffff',
		'description' => __( 'Set color for this section.', 'avata' )
	);
  
  $options['avata_section_image_content_background_color'] = array(
		'id' => 'avata_section_image_content_background_color',
		'label'   => __( 'Background Color', 'avata' ),
		'section' => $section,
		'type'    => 'color',
		
		'description' => __( 'Set background color for this section.', 'avata' )
	);
	
	$options['avata_section_image_content_background_image'] = array(
		'id' => 'avata_section_image_content_background_image',
		'label'   => __( 'Background Image', 'avata' ),
		'section' => $section,
		'type'    => 'upload',
		
		'description' => __( 'Upload background image for this section.', 'avata' )
	);
	
	$options['avata_section_image_content_background_repeat'] = array(
		'id' => 'avata_section_image_content_background_repeat',
		'label'   => __( 'Background Repeat', 'avata' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $repeat,
		'default' => 'no-repeat',
		
	);
	
	$options['avata_section_image_content_background_full'] = array(
		'id' => 'avata_section_image_content_background_full',
		'label'   => __( 'Background Image 100% Width', 'avata' ),
		'section' => $section,
		'type'    => 'checkbox',
		
		'default' => '1',
		
	);
	
	$options['avata_section_image_content_top_padding'] = array(
		'id' => 'avata_section_image_content_top_padding',
		'label' => __( 'Section Top Padding', 'avata' ),
		'description' => __( 'In pixels, ex: 10px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '6.5rem',
	);
	
	$options['avata_section_image_content_bottom_padding'] = array(
		'id' => 'avata_section_image_content_bottom_padding',
		'label' => __( 'Section Bottom Padding', 'avata' ),
		'description' => __( 'In pixels, ex: 10px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '0',
	);
	
	$options['avata_section_image_content_min_height'] = array(
		'id' => 'avata_section_image_content_min_height',
		'label' => __( 'Section Min Height', 'avata' ),
		'description' => __( 'In pixels, ex: 500px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '30.5rem',
	);
	
  $options['avata_section_image_content_page'] = array(
		'id' => 'avata_section_image_content_page',
		'label' => __( 'Select Page', 'avata' ),
		'description'   => __( 'Content Button HTML', 'avata' ).': &lt;a class="btn btn-lg btn-grey" href="#"&gt;Button&lt;/a&gt;',
		'section' => $section,
		'type'    => 'select',
		'choices' => $options_pages,
		
	);
  $options['avata_section_image_content_bottom'] = array(
		'id' => 'avata_section_image_content_bottom',
		'label' => __( 'Bottom Image?', 'avata' ),
		
		'section' => $section,
		'type'    => 'checkbox',
		'choices' => '',
		'default' => '1',
	);		
  $options['avata_section_image_content_id'] = array(
		'id' => 'avata_section_image_content_id',
		'label' => __( 'Section ID', 'avata' ),
		
		'section' => $section,
		'type'    => 'text',
		'default' => 'section-content-image',
	);
  
  
   // Section Promo
	$section = 'avata-section-promo';
	
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Section - Promo', 'avata' ),
		'priority' => '10',
		
		'panel' => $panel
	);
  $options['avata_section_promo_enable'] = array(
		'id' => 'avata_section_promo_enable',
		'label' => __( 'Enable Section', 'avata' ),
		
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '1',
	);	
  $options['avata_section_promo_color'] = array(
		'id' => 'avata_section_promo_color',
		'label'   => __( 'Color', 'avata' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#ffffff',
		'description' => __( 'Set color for this section.', 'avata' )
	);
  
  $options['avata_section_promo_background_color'] = array(
		'id' => 'avata_section_promo_background_color',
		'label'   => __( 'Background Color', 'avata' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#723080',
		'description' => __( 'Set background color for this section.', 'avata' )
	);
	
	$options['avata_section_promo_background_image'] = array(
		'id' => 'avata_section_promo_background_image',
		'label'   => __( 'Background Image', 'avata' ),
		'section' => $section,
		'type'    => 'upload',
		
		'description' => __( 'Upload background image for this section.', 'avata' )
	);
	
	$options['avata_section_promo_background_repeat'] = array(
		'id' => 'avata_section_promo_background_repeat',
		'label'   => __( 'Background Repeat', 'avata' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $repeat,
		'default' => 'no-repeat',
		
	);
	
	$options['avata_section_promo_background_full'] = array(
		'id' => 'avata_section_promo_background_full',
		'label'   => __( 'Background Image 100% Width', 'avata' ),
		'section' => $section,
		'type'    => 'checkbox',
		
		'default' => '1',
		
	);
	
	$options['avata_section_promo_top_padding'] = array(
		'id' => 'avata_section_promo_top_padding',
		'label' => __( 'Section Top Padding', 'avata' ),
		'description' => __( 'In pixels, ex: 10px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '4.5rem',
	);
	
	$options['avata_section_promo_bottom_padding'] = array(
		'id' => 'avata_section_promo_bottom_padding',
		'label' => __( 'Section Bottom Padding', 'avata' ),
		'description' => __( 'In pixels, ex: 10px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		'default' => '4.5rem',
	);
	
	$options['avata_section_promo_min_height'] = array(
		'id' => 'avata_section_promo_min_height',
		'label' => __( 'Section Min Height', 'avata' ),
		'description' => __( 'In pixels, ex: 500px.', 'avata' ),
		'section' => $section,
		'type'    => 'text',
		
	);
	
  $options['avata_section_promo_info'] = array(
		'id' => 'avata_section_promo_info',
		'label' => __( 'Description', 'avata' ),
		
		'section' => $section,
		'type'    => 'text',
		'choices' => '',
		'default' => '<h2>Ready to <b>Get Started</b>?</h2>',
	);
 
 $options['avata_section_promo_btn_text_1'] = array(
		'id' => 'avata_section_promo_btn_text_1',
		'label' => __( 'Button Text 1', 'avata' ),
		
		'section' => $section,
		'type'    => 'text',
		'default' => 'Download it Free',
	);
	$options['avata_section_promo_btn_link_1'] = array(
		'id' => 'avata_section_promo_btn_link_1',
		'label' => __( 'Button Link 1', 'avata' ),
		
		'section' => $section,
		'type'    => 'text',
		'default' => '#',
	);
	$options['avata_section_promo_btn_target_1'] = array(
		'id' => 'avata_section_promo_btn_target_1',
		'label' => __( 'Button Link Target 1', 'avata' ),
		
		'section' => $section,
		'type'    => 'select',
		'choices' => $target,
		'default' => '_blank',
	);
	
	 $options['avata_section_promo_btn_text_2'] = array(
		'id' => 'avata_section_promo_btn_text_2',
		'label' => __( 'Button Text 2', 'avata' ),
		
		'section' => $section,
		'type'    => 'text',
		'default' => 'View support forum',
	);
	$options['avata_section_promo_btn_link_2'] = array(
		'id' => 'avata_section_promo_btn_link_2',
		'label' => __( 'Button Link 2', 'avata' ),
		
		'section' => $section,
		'type'    => 'text',
		'default' => '#',
	);
	$options['avata_section_promo_btn_target_2'] = array(
		'id' => 'avata_section_promo_btn_target_2',
		'label' => __( 'Button Link Target 2', 'avata' ),
		
		'section' => $section,
		'type'    => 'select',
		'choices' => $target,
		'default' => '_blank',
	);
 
  $options['avata_section_promo_id'] = array(
		'id' => 'avata_section_promo_id',
		'label' => __( 'Section ID', 'avata' ),
		
		'section' => $section,
		'type'    => 'text',
		'default' => 'section-promo',
	);
	##### General panel #####


	$section = 'avata_general';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'General', 'avata' ),
		'priority' => '11',
		
	);
	
	$options['avata_custom_css'] =  array(
			'id'          => 'avata_custom_css',
			'label'       => __( 'Custom CSS', 'avata' ),
			'description' => __( 'The following css code will add to the header before the closing &lt;/head&gt; tag.', 'avata'),
			'default'     => '#custom {
				}',
			'type'        => 'textarea',
			'section'     => $section,
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'wp_filter_nohtml_kses',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses'
			
		  );


  ### Blog ###
    $panel = 'blog';

	$panels[] = array(
		'id' => $panel,
		'title' => __( 'Blog', 'avata' ),
		'priority' => '13'
	);
	
	// Blog Meta Options
    $section = 'blog_meta_options';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Blog Meta Options', 'avata' ),
		'priority' => '11',
		
		'panel' => $panel
	);

$options['avata_display_post_meta'] =  array(
        'id'          => 'avata_display_post_meta',
        'label'      => __( 'Display Post Meta', 'avata' ),
        'description'        => __( 'Choose to display post meta in blog posts.', 'avata' ),
        'default'         => '1',
        'type'        => 'select',
        'section' => $section,
        'choices'     =>  $choices
	
      );
$options['avata_display_meta_author'] =  array(
        'id'          => 'avata_display_meta_author',
        'label'      => __( 'Display Post Meta Author', 'avata' ),
        'default'         => '1',
        'type'        => 'select',
        'section' => $section,
        'choices'     =>  $choices
	
      );
$options['avata_display_meta_date'] =  array(
        'id'          => 'avata_display_meta_date',
        'label'      => __( 'Display Post Meta Date', 'avata' ),
        'default'         => '1',
        'type'        => 'select',
        'section' => $section,
        'choices'     =>  $choices
	
      );
$options['avata_display_meta_categories'] =  array(
        'id'          => 'avata_display_meta_categories',
        'label'      => __( 'Display Post Meta Categories', 'avata' ),
        'default'         => '1',
        'type'        => 'select',
        'section' => $section,
        'choices'     =>  $choices
	
      );

$options['avata_display_meta_comments'] =  array(
        'id'          => 'avata_display_meta_comments',
        'label'      => __( 'Display Post Meta Comments', 'avata' ),
        'default'         => '1',
        'type'        => 'select',
        'section' => $section,
        'choices'     =>  $choices
	
      );
$options['avata_display_meta_readmore'] =  array(
        'id'          => 'avata_display_meta_readmore',
        'label'      => __( 'Display Post Meta Readmore', 'avata' ),
        'default'         => '1',
        'type'        => 'select',
        'section' => $section,
        'choices'     =>  $choices
	
      );
$options['avata_display_meta_tags'] =  array(
        'id'          => 'avata_display_meta_tags',
        'label'      => __( 'Display Post Meta Tags', 'avata' ),
        'default'         => '1',
        'type'        => 'select',
        'section' => $section,
         'choices'     =>  $choices
	
      );

  ### Footer ###
	$section = 'avata_footer';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Footer', 'avata' ),
		'priority' => '14',
		
	);
	
	$options['avata_display_footer_widgets'] =  array(
			'id'          => 'avata_display_footer_widgets',
			'label'       => __( 'Display Footer Widgets', 'avata' ),
			'type'        => 'checkbox',
			'section'     => $section,
			'default'     => '1',
		  );
   $options['avata_footer_columns'] =  array(
			'id'          => 'avata_footer_columns',
			'label'       => __( 'Footer Widgets Columns', 'avata' ),
			'type'        => 'select',
			'section'     => $section,
			'choices'     => array(1=>1,2=>2,3=>3,4=>4),
			'default'     => '4',
		  );



    $avata_default_options = array();
	foreach ( (array) $options as $option ) {
									  if ( ! isset( $option['id'] ) ) {
										  continue;
									  }
									  if ( ! isset( $option['default'] ) ) {
										  continue;
									  }
    $avata_default_options[$option['id']] = $option['default'];
	}


	// Adds the sections to the $options array
	$options['sections'] = $sections;

	// Adds the panels to the $options array
	$options['panels'] = $panels;

	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

	// To delete custom mods use: customizer_library_remove_theme_mods();

}
add_action( 'init', 'avata_customizer_options' );
