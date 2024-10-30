<?php
function mmd_pf_register_metaboxes(){

	function sanitised_content_mmd($content){
		return wp_kses_post($content);
	}
	
	function sanitised_button_content_mmd($content){
		return balanceTags($content, true);
	}
	
	/**
	* Set our taxonomy as options for a multicheck field to be used later. 
	* @param  CMB2_Field $field 
	* @return array An array of options that matches the CMB2 options array
	*/
	function cmb2_get_term_options( $field ) {
		$args = $field->args( 'get_terms_args' );
		$args = is_array( $args ) ? $args : array();

		$args = wp_parse_args( $args, array( 'taxonomy' => 'filters' ) );

		$taxonomy = $args['taxonomy'];

		$terms = (array) cmb2_utils()->wp_at_least( '4.5.0' )
			? get_terms( $args )
			: get_terms( $taxonomy, $args );

		// Initate an empty array
		$term_options = array();
		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$term_options[ $term->name ] = $term->name;
			}
		}

		return $term_options;
	}



	$prefix = '_mmd_';
	
	
	$menu_group = new_cmb2_box(array(
		'id' 				=> $prefix . 'menu_metabox',
		'title'				=> __('Portfolio filter settings', 'mmd_pf'),
		'object_types'		=> array('mmd_pf'), //Feed the post type name here
		'closed'			=> true,
	));

		$menu_group->add_field(array(
			'name'				=> __('Title', 'mmd_pf').'  <a title="'.__('The title for your portfolio.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
			'id'				=> $prefix . 'menu_title', 
			'type'				=>	'text', 
			'row_classes'		=> 'mmd_twothird mmd_text mmd_entry mmd_left',
			'sanitization_cb'	=> 'sanitised_content_mmd'
		));

		$menu_group->add_field(array(
			'name'				=> __('Separator', 'mmd_pf').'  <a title="'.__('Set up a separator to place between the title and filters.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
			'id'				=> $prefix . 'menu_separator', 
			'type'				=>	'radio_inline', 
			'row_classes'		=> 'mmd_twothird mmd_radio mmd_entry mmd_left',
			'options' 			=> array(
				'sep_none' 		=> __( 'No Separator', 'mmd_pf' ),
				'sep_sm'   		=> __( 'Small', 'mmd_pf' ),
				'sep_med'     	=> __( 'Medium', 'mmd_pf' ),
				'sep_lg'     	=> __( 'Large', 'mmd_pf' ),
			),
				'default' 		=> 'sep_one'
		));
		
		$menu_group->add_field(array(
			'name' 				=> __( 'Filters', 'mmd_pf' ).'  <a title="'.__('Select the filters that you would like to use for this portfolio.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
			'id' 				=> $prefix . 'menu_filters',
			'type' 				=> 'taxonomy_multicheck_inline',
			'taxonomy' 			=> 'filters',
			'desc'				=> '<span class="dashicons dashicons-warning"></span> '.__('Unchecking all filters will remove filter functionality altogether.', 'mmd_pf'),
			'row_classes' 		=> 'mmd_twothird mmd_entry mmd_left mmd_taxonomy',
            ));
		
		$menu_group->add_field(array(
                'name' 			=> __( 'Example', 'mmd_pf' ),
                'desc' 			=> '<img src="../wp-content/plugins/mmd_pf/img/sample-1.png"/>',
                'id'   			=> $prefix . 'menu_sample',
                'type' 			=> 'title',
                'row_classes' 	=> 'mmd_onethird mmd_sample_img',
            ));
		
		$menu_group->add_field(array(
				'name'			=> __('Filter Colors', 'mmd_pf'),
				'id'			=> $prefix . 'filter_color_header',
				'type'			=> 'title',
				'row_classes'	=> 'mmd_twothird mmd_left mmd_title'
		));
		
		$menu_group->add_field(array(
				'name'			=> __('Text Color', 'mmd_pf').'  <a title="'.__('The standard color for all filter categories.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
                'id' 			=> $prefix . 'filter_color_text',
				'desc' 			=> __('Default is #666666', 'mmd_pf'),
                'type' 			=> 'colorpicker',
	              'default'  	=> '#666666',
                'row_classes' 	=> 'mmd_full mmd_color mmd_entry',
            ));
		
		$menu_group->add_field(array(
				'name'			=> __('Active Text Color', 'mmd_pf').'  <a title="'.__('The color for the currently active filter category.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
                'id' 			=> $prefix . 'filter_color_text_active',
				'desc' 			=> __('Default is #ffffff', 'mmd_pf'),
                'type' 			=> 'colorpicker',
	              'default'  	=> '#ffffff',
                'row_classes' 	=> 'mmd_full mmd_color mmd_entry',
            ));
		
		$menu_group->add_field(array(
				'name'			=> __('Active Background Color', 'mmd_pf').'  <a title="'.__('The background color for the currently active filter category.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
                'id' 			=> $prefix . 'filter_color_background',
				'desc' 			=> __('Default is #5acae6', 'mmd_pf'),
                'type' 			=> 'colorpicker',
	              'default'  	=> '#5acae6',
                'row_classes' 	=> 'mmd_full mmd_color mmd_entry',
            ));
		
		
		
	$general_item_group = new_cmb2_box(array(
		'id' 				=> $prefix . 'item_metabox',
		'title'				=> __('General item settings', 'mmd_pf'),
		'object_types'		=> array('mmd_pf'), //Feed the post type name here
	));	
		
		$general_item_group->add_field(array(
				'name'			=> __('Overlay Color', 'mmd_pf').'  <a title="'.__('The color for the hover overlay for each item.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
                'id' 			=> $prefix . 'general_color_overlay',
				'desc' 			=> __('Default is #000000', 'mmd_pf'),
                'type' 			=> 'colorpicker',
	              'default'  	=> '#000000',
                'row_classes' 	=> 'mmd_twothird mmd_left mmd_color mmd_entry',
            ));
			
		$general_item_group->add_field(array(
				'name'			=> __('Text Color', 'mmd_pf').'  <a title="'.__('The color for the text within each item.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
                'id' 			=> $prefix . 'general_color_text',
				'desc' 			=> __('Default is #ffffff. This color will also apply to the separator.', 'mmd_pf'),
                'type' 			=> 'colorpicker',
	              'default'  	=> '#ffffff',
                'row_classes' 	=> 'mmd_twothird mmd_left mmd_color mmd_entry',
            ));
			
		$general_item_group->add_field(array(
			'name'				=> __('Decorator', 'mmd_pf').'  <a title="'.__('Select a decorator to place between the title and information.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
			'id'				=> $prefix . 'general_decorator', 
			'desc'				=>__('Hover over each option for a preview!', 'mmd_pf'),
			'type'				=>	'radio_inline', 
			'row_classes'		=> 'mmd_twothird mmd_left mmd_radio mmd_entry mmd_decorator',
			'options' 			=> array(
				'gen_dec_none' 		=> __( 'No Decorator', 'mmd_pf' ),
				'gen_dec_one'   	=> __( 'All Corners', 'mmd_pf' ),
				'gen_dec_two'     	=> __( 'Two Corners', 'mmd_pf' ),
				'gen_dec_three'     => __( 'Tilted Corners', 'mmd_pf' ),
				'gen_dec_four'     	=> __( 'Lines', 'mmd_pf' ),
				'gen_dec_five'      => __( 'Angled', 'mmd_pf' ),
			),
				'default' 		=> 'gen_dec_one'
		));	
			
		$general_item_group->add_field( array(
			'name'				=> __('Items per row', 'mmd_pf').'  <a title="'.__('Select the number of items you want to fit in a horizontal row.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
			'id'      			=> $prefix . 'item_size',
			'type'   			=> 'select',
			'desc'				=> '<span class="dashicons dashicons-warning"></span> '.__('Smaller items allows more items in one row; larger items will allow for more content inside each item.', 'mmd_pf'),
			'options' => array(
			    'item_small'   => __( '4', 'mmd_pf' ),
			    'item_medium'   => __( '3', 'mmd_pf' ),
			    'item_large'   => __( '2', 'mmd_pf' ),
			),
            'default' => 'normal',
            'row_classes' => 'mmd_twothird mmd_left mmd_select mmd_entry',
        ));	
			
		$general_item_group->add_field(array(
                'name' 			=> __( 'Example', 'mmd_pf' ),
                'desc' 			=> '<img src="../wp-content/plugins/mmd_pf/img/sample-2.png"/>',
                'id'   			=> $prefix . 'general_sample',
                'type' 			=> 'title',
                'row_classes' 	=> 'mmd_onethird mmd_sample_img',
            ));
		
	$single_item_settings = new_cmb2_box(array(
		'id' 				=> $prefix . 'single_item_metabox',
		'title'				=> __('Single item settings', 'mmd_pf'),
		'object_types'		=> array('mmd_pf'), //Feed the post type name here
	));		

		$single_item_group = $single_item_settings->add_field(array(
			'id'				=> $prefix . 'single_group', 
			'type'				=>	'group', 
			'options'			=> array(
				'group_title'		=> __('Item {#}', 'mmd_pf' ),
				'add_button'		=> __('Add another item', 'mmd_pf'),
				'remove_button'		=> __('Remove Item', 'mmd_pf'),
				'sortable' 			=> true,
			)	
		));
	
		$single_item_settings->add_group_field($single_item_group, array(
			'name'				=> __('Item Image', 'mmd_pf').'  <a title="'.__('The image for this portfolio item.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
			'id'				=> $prefix . 'single_item_image', 
			'type'				=>	'file', 
			'desc'				=>  __('Remember that the image will be resized based on the item size you selected earlier.', 'mmd_pf'),
			'row_classes'		=> 'mmd_full mmd_file mmd_entry mmd_left',
			'text'   			 => array(
					'add_upload_file_text' => 'Add Image'),
		));
	
		$single_item_settings->add_group_field($single_item_group, array(
			'name'				=> __('Title', 'mmd_pf').'  <a title="'.__('The title for this portfolio item.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
			'id'				=> $prefix . 'single_item_header', 
			'type'				=>	'text', 
			'row_classes'		=> 'mmd_full mmd_text mmd_entry mmd_left',
			'sanitization_cb'	=> 'sanitised_content_mmd'
		));
		
	
		$single_item_settings->add_group_field($single_item_group, array(
			'name'				=> __('Destination', 'mmd_pf').'  <a title="'.__('The URL this portfolio item will link to.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
			'id'				=> $prefix . 'single_item_link', 
			'type'				=>	'text_url', 
			'desc'				=> 	'<span class="dashicons dashicons-warning"></span> '.__('Be sure to enter a valid URL.', 'mmd_pf'),
			'row_classes'		=> 'mmd_full mmd_text mmd_entry mmd_left',
			'sanitization_cb'	=> 'sanitised_content_mmd'
		));
		
		$single_item_settings->add_group_field($single_item_group, array(
			'name' 				=> __( 'Filters', 'mmd_pf' ).'  <a title="'.__('Select the filters that you would like to use for this item.', 'mmd_pf').'"><span class="dashicons dashicons-editor-help"></span></a>',
			'id' 				=> $prefix . 'single_item_filters',
			'type' 				=> 'multicheck_inline',
			'options_cb' 		=> 'cmb2_get_term_options',
			'select_all_button' => false,
			'desc'				=> '<span class="dashicons dashicons-warning"></span> '.__('Unchecking all filters will remove filter functionality from this item. Multiple categories are allowed.', 'mmd_pf'),
			'row_classes' 		=> 'mmd_full mmd_entry mmd_left mmd_taxonomy',
			'get_terms_args'	=> array(
						'taxonomy'   => 'filters',
						'hide_empty' => false,
					),
            ));
		
}
