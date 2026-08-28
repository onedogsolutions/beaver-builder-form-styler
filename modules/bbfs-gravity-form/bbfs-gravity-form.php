<?php

/**
 * @class BBFS_Gravity_Form_Module
 */
class BBFS_Gravity_Form_Module extends FLBuilderModule {

	/**
	 * Constructor function for the module. You must pass the
	 * name, description, dir and url in an array to the parent class.
	 *
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(
			array(
				'name'          => __( 'Gravity Form', 'bb-form-styler' ),
				'description'   => __( 'A module for Gravity Form.', 'bb-form-styler' ),
				'category'      => BBFS_Helpers::get_modules_cat( 'form_style' ),
				'dir'           => BBFS_DIR . 'modules/bbfs-gravity-form/',
				'url'           => BBFS_URL . 'modules/bbfs-gravity-form/',
				'editor_export' => true, // Defaults to true and can be omitted.
				'enabled'       => true, // Defaults to true and can be omitted.
			)
		);

	}

	public function enqueue_scripts() {
		if ( BBFS_Helpers::is_builder_request() ) {
			wp_enqueue_style( 'gforms_formsmain_css' );
		}
	}

	public static function gf_forms_dropdown_options() {
		$options = array( '' => __( 'None', 'bb-form-styler' ) );

		if ( ! BBFS_Helpers::is_builder_request() ) {
			return $options;
		}

		global $wpdb;

		if ( class_exists( 'GFForms' ) ) {
			$form_table_name = GFFormsModel::get_form_table_name();
			$id              = 0;
			$forms           = $wpdb->get_results( $wpdb->prepare( 'SELECT id, title FROM ' . $form_table_name . ' WHERE id != %d', $id ), OBJECT );
			if ( ! is_wp_error( $forms ) ) {
				foreach ( $forms as $form ) {
					$options[ $form->id ] = esc_html( $form->title );
				}
			}
		}

		return $options;
	}

}



/**
	* Register the module and its form settings.
	*/
FLBuilder::register_module(
	'BBFS_Gravity_Form_Module',
	array(
		'form'            => array( // Tab
			'title'    => __( 'General', 'bb-form-styler' ), // Tab title
			'sections' => array( // Tab Sections
				'select_form'   => array( // Section
					'title'  => '', // Section Title
					'fields' => array( // Section Fields
						'select_form_field' => array(
							'type'        => 'select',
							'label'       => __( 'Select Form', 'bb-form-styler' ),
							'default'     => '',
							'options'     => BBFS_Gravity_Form_Module::gf_forms_dropdown_options(),
							'connections' => array( 'string' ),
						),
					),
				),
				'form_settings' => array(
					'title'  => __( 'Settings', 'bb-form-styler' ),
					'fields' => array(
						'form_custom_title_desc' => array(
							'type'    => 'button-group',
							'label'   => __( 'Custom Title & Description', 'bb-form-styler' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-form-styler' ),
								'no'  => __( 'No', 'bb-form-styler' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields' => array( 'custom_title', 'custom_description' ),
								),
								'no'  => array(
									'fields' => array( 'title_field', 'description_field' ),
								),
							),
						),
						'title_field'            => array(
							'type'    => 'button-group',
							'label'   => __( 'Title', 'bb-form-styler' ),
							'default' => 'true',
							'options' => array(
								'true'  => __( 'Show', 'bb-form-styler' ),
								'false' => __( 'Hide', 'bb-form-styler' ),
							),
						),
						'custom_title'           => array(
							'type'        => 'text',
							'label'       => __( 'Custom Title', 'bb-form-styler' ),
							'default'     => '',
							'description' => '',
							'connections' => array( 'string' ),
							'preview'     => array(
								'type'     => 'text',
								'selector' => '.bbfs-form-title',
							),
						),
						'description_field'      => array(
							'type'    => 'button-group',
							'label'   => __( 'Description', 'bb-form-styler' ),
							'default' => 'true',
							'options' => array(
								'true'  => __( 'Show', 'bb-form-styler' ),
								'false' => __( 'Hide', 'bb-form-styler' ),
							),
						),
						'custom_description'     => array(
							'type'        => 'textarea',
							'label'       => __( 'Custom Description', 'bb-form-styler' ),
							'default'     => '',
							'placeholder' => '',
							'rows'        => '6',
							'connections' => array( 'string', 'html' ),
							'preview'     => array(
								'type'     => 'text',
								'selector' => '.bbfs-form-description',
							),
						),
						'display_labels'         => array(
							'type'    => 'button-group',
							'label'   => __( 'Labels', 'bb-form-styler' ),
							'default' => 'block',
							'options' => array(
								'block' => __( 'Show', 'bb-form-styler' ),
								'none'  => __( 'Hide', 'bb-form-styler' ),
							),
						),
						'form_tab_index'         => array(
							'type'    => 'text',
							'label'   => __( 'Tab Index', 'bb-form-styler' ),
							'class'   => 'bb-gf-input input-small',
						),
					),
				),
			),
		),
		'style'           => array( // Tab
			'title'    => __( 'Style', 'bb-form-styler' ), // Tab title
			'sections' => array( // Tab Sections
				'form_setting'   => array( // Section
					'title'  => __( 'Form Background', 'bb-form-styler' ), // Section Title
					'fields' => array( // Section Fields
						'form_bg_type'            => array(
							'type'    => 'button-group',
							'label'   => __( 'Background Type', 'bb-form-styler' ),
							'default' => 'color',
							'options' => array(
								'color' => __( 'Color', 'bb-form-styler' ),
								'image' => __( 'Image', 'bb-form-styler' ),
							),
							'toggle'  => array(
								'color' => array(
									'fields' => array( 'form_bg_color' ),
								),
								'image' => array(
									'fields' => array( 'form_bg_image', 'form_bg_size', 'form_bg_repeat', 'form_bg_overlay', 'form_bg_overlay_opacity' ),
								),
							),
						),
						'form_bg_color'           => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-form-styler' ),
							'default'     => 'ffffff',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.bbfs-gravity-form-content',
								'property' => 'background-color',
							),
						),
						'form_bg_image'           => array(
							'type'        => 'photo',
							'label'       => __( 'Background Image', 'bb-form-styler' ),
							'default'     => '',
							'show_remove' => true,
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.bbfs-gravity-form-content',
								'property' => 'background-image',
							),
						),
						'form_bg_size'            => array(
							'type'    => 'button-group',
							'label'   => __( 'Background Size', 'bb-form-styler' ),
							'default' => 'cover',
							'options' => array(
								'contain' => __( 'Contain', 'bb-form-styler' ),
								'cover'   => __( 'Cover', 'bb-form-styler' ),
							),
						),
						'form_bg_repeat'          => array(
							'type'    => 'button-group',
							'label'   => __( 'Background Repeat', 'bb-form-styler' ),
							'default' => 'no-repeat',
							'options' => array(
								'repeat-x'  => __( 'Repeat X', 'bb-form-styler' ),
								'repeat-y'  => __( 'Repeat Y', 'bb-form-styler' ),
								'no-repeat' => __( 'No Repeat', 'bb-form-styler' ),
							),
						),
						'form_bg_overlay'         => array(
							'type'        => 'color',
							'label'       => __( 'Background Overlay Color', 'bb-form-styler' ),
							'default'     => '000000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'form_bg_overlay_opacity' => array(
							'type'        => 'text',
							'label'       => __( 'Background Overlay Opacity', 'bb-form-styler' ),
							'class'       => 'bb-gf-input input-small',
							'default'     => '50',
							'description' => __( '%', 'bb-form-styler' ),
						),
					),
				),
				'form_border'    => array(
					'title'     => __( 'Form Border', 'bb-form-styler' ),
					'collapsed' => true,
					'fields'    => array(
						'form_border_group' => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.bbfs-gravity-form-content',
							),
						),
					),
				),
				'form_container' => array(
					'title'     => __( 'Padding', 'bb-form-styler' ),
					'collapsed' => true,
					'fields'    => array(
						'form_padding' => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-form-styler' ),
							'slider'     => true,
							'units'      => array( 'px' ),
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.bbfs-gravity-form-content',
								'property' => 'padding',
								'unit'     => 'px',
							),
							'responsive' => true,
						),
					),
				),
				'general_style'  => array( // Section
					'title'     => __( 'General', 'bb-form-styler' ), // Section Title
					'collapsed' => true,
					'fields'    => array( // Section Fields
						'product_price_color' => array(
							'type'        => 'color',
							'label'       => __( 'Product Price Color', 'bb-form-styler' ),
							'default'     => '900900',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper span.ginput_product_price',
								'property' => 'color',
							),
						),
					),
				),
				'section_style'  => array( // Section
					'title'     => __( 'Sections', 'bb-form-styler' ), // Section Title
					'collapsed' => true,
					'fields'    => array( // Section Fields
						'section_border_width' => array(
							'type'    => 'unit',
							'label'   => __( 'Border Width', 'bb-form-styler' ),
							'default' => 1,
							'slider'  => array(
								'px' => array(
									'min'  => 0,
									'max'  => 10,
									'step' => 1,
								),
							),
							'units'   => array( 'px' ),
							'preview' => array(
								'type'     => 'css',
								'selector' => '.bbfs-gravity-form-content .gform_wrapper .gsection',
								'property' => 'border-bottom-width',
							),
						),
						'section_border_color' => array(
							'type'        => 'color',
							'label'       => __( 'Border Color', 'bb-form-styler' ),
							'default'     => 'cccccc',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.bbfs-gravity-form-content .gform_wrapper .gsection',
								'property' => 'border-bottom-color',
							),
						),
						'section_field_margin' => array(
							'type'    => 'unit',
							'label'   => __( 'Margin Bottom', 'bb-form-styler' ),
							'slider'  => array(
								'px' => array(
									'min'  => 0,
									'max'  => 50,
									'step' => 1,
								),
							),
							'units'   => array( 'px' ),
							'default' => '20',
							'preview' => array(
								'type'     => 'css',
								'selector' => '.bbfs-gravity-form-content .gform_wrapper .gsection',
								'property' => 'margin-bottom',
							),
						),
					),
				),
			),
		),
		'input_style'     => array(
			'title'    => __( 'Inputs', 'bb-form-styler' ),
			'sections' => array(
				'input_general'     => array( // Section
					'title'     => '', // Section Title
					'fields'    => array( // Section Fields
						'input_field_width'          => array(
							'type'    => 'button-group',
							'label'   => __( 'Full Width', 'bb-form-styler' ),
							'default' => 'false',
							'options' => array(
								'true'  => __( 'Yes', 'bb-form-styler' ),
								'false' => __( 'No', 'bb-form-styler' ),
							),
						),
						'input_field_height'         => array(
							'type'    => 'button-group',
							'label'   => __( 'Height', 'bb-form-styler' ),
							'default' => 'auto',
							'options' => array(
								'auto'   => __( 'Auto', 'bb-form-styler' ),
								'custom' => __( 'Custom', 'bb-form-styler' ),
							),
							'toggle'  => array(
								'custom' => array(
									'fields' => array( 'input_field_height_custom' ),
								),
							),
						),
						'input_field_height_custom'  => array(
							'type'    => 'unit',
							'label'   => __( 'Custom Height', 'bb-form-styler' ),
							'default' => '45',
							'slider'  => true,
							'units'   => array( 'px' ),
							'preview' => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .gform_wrapper .gfield select',
								'property' => 'height',
								'unit'     => 'px',
							),
						),
						'input_field_padding'        => array(
							'type'       => 'unit',
							'label'      => __( 'Padding', 'bb-form-styler' ),
							'slider'     => true,
							'units'      => array( 'px' ),
							'default'    => '',
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield:not(.gfield--type-address):not(.address) input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .gform_wrapper .gfield:not(.gfield--type-address):not(.address) select, .gform_wrapper .gfield:not(.gfield--type-address):not(.address) textarea',
								'property' => 'padding',
								'unit'     => 'px',
							),
							'responsive' => true,
						),
						'input_field_margin'         => array(
							'type'    => 'unit',
							'label'   => __( 'Margin Bottom', 'bb-form-styler' ),
							'slider'  => true,
							'units'   => array( 'px' ),
							'default' => '',
							'preview' => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield:not(.gfield--type-address):not(.address) input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .gform_wrapper .gfield:not(.gfield--type-address):not(.address) select, .gform_wrapper .gfield:not(.gfield--type-address):not(.address) textarea',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
					),
				),
				'address_block'     => array(
					'title'     => __( 'Address Block', 'bb-form-styler' ),
					'collapsed' => true,
					'fields'    => array(
						'address_block_padding'       => array(
							'type'       => 'unit',
							'label'      => __( 'Padding', 'bb-form-styler' ),
							'slider'     => true,
							'units'      => array( 'px' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield.gfield--type-address, .gform_wrapper .gfield.address',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
						'address_block_margin_bottom' => array(
							'type'       => 'unit',
							'label'      => __( 'Margin Bottom', 'bb-form-styler' ),
							'slider'     => true,
							'units'      => array( 'px' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield.gfield--type-address, .gform_wrapper .gfield.address',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
					),
				),
				'input_background'  => array(
					'title'  => __( 'Colors', 'bb-form-styler' ),
					'collapsed' => true,
					'fields' => array(
						'input_field_text_color' => array(
							'type'        => 'color',
							'label'       => __( 'Text Color', 'bb-form-styler' ),
							'default'     => '',
							'connections' => array( 'color' ),
							'show_reset'	=> true,
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .gform_wrapper .gfield select, .gform_wrapper .gfield textarea',
								'property' => 'color',
							),
						),
						'input_field_bg_color'   => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .gform_wrapper .gfield select, .gform_wrapper .gfield textarea',
								'property' => 'background-color',
							),
						),
						'form_label_color'         => array(
							'type'        => 'color',
							'label'       => __( 'Label Color', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.bbfs-gravity-form-content .gform_wrapper .gfield .gfield_label, .bbfs-gravity-form-content .gform_wrapper table.gfield_list thead th, .bbfs-gravity-form-content .gform_wrapper span.ginput_product_price_label, .bbfs-gravity-form-content .gform_wrapper span.ginput_quantity_label, .bbfs-gravity-form-content .gform_wrapper .gfield_html',
								'property' => 'color',
							),
						),
						'form_required_text_color'         => array(
							'type'        => 'color',
							'label'       => __( 'Label "Required" Text Color', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.bbfs-gravity-form-content .gform_wrapper .gfield_required',
								'property' => 'color',
							),
						),
						'input_desc_color'       => array(
							'type'        => 'color',
							'label'       => __( 'Input Description Color', 'bb-form-styler' ),
							'default'     => '',
							'connections' => array( 'color' ),
							'show_reset'	=> true,
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.bbfs-gravity-form-content .gform_wrapper .gfield .gfield_description',
								'property' => 'color',
							),
						),
					),
				),
				'input_border'      => array(
					'title'     => __( 'Border & Shadow', 'bb-form-styler' ),
					'collapsed' => true,
					'fields'    => array(
						'input_field_border_group' => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .gform_wrapper .gfield select, .gform_wrapper .gfield textarea',
							),
						),
						'input_field_focus_color'     => array(
							'type'        => 'color',
							'label'       => __( 'Focus Border Color', 'bb-form-styler' ),
							'default'     => '719ece',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]):focus, .gform_wrapper .gfield select:focus, .gform_wrapper .gfield textarea:focus',
								'property' => 'border-color',
							),
						),
					),
				),
				'placeholder_style' => array( // Section
					'title'     => __( 'Placeholder', 'bb-form-styler' ), // Section Title
					'collapsed' => true,
					'fields'    => array( // Section Fields
						'gf_input_placeholder_display' => array(
							'type'    => 'button-group',
							'label'   => __( 'Show Placeholder', 'bb-form-styler' ),
							'default' => 'block',
							'options' => array(
								'block' => __( 'Yes', 'bb-form-styler' ),
								'none'  => __( 'No', 'bb-form-styler' ),
							),
							'toggle'  => array(
								'block' => array(
									'fields' => array( 'gf_input_placeholder_color' ),
								),
							),
						),
						'gf_input_placeholder_color'   => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-form-styler' ),
							'default'     => 'eeeeee',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input::-webkit-input-placeholder, .gform_wrapper .gfield select::-webkit-input-placeholder, .gform_wrapper .gfield textarea::-webkit-input-placeholder',
								'property' => 'color',
							),
						),
					),
				),
				'radio_cb_style'    => array(
					'title'     => __( 'Radio & Checkbox', 'bb-form-styler' ),
					'collapsed' => true,
					'fields'    => array(
						'radio_cb_style'           => array(
							'type'    => 'button-group',
							'label'   => __( 'Enable Custom Style', 'bb-form-styler' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-form-styler' ),
								'no'  => __( 'No', 'bb-form-styler' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields' => array( 'radio_cb_size', 'radio_cb_color', 'radio_cb_checked_color', 'radio_cb_border_width', 'radio_cb_border_color', 'radio_cb_radius', 'radio_cb_checkbox_radius' ),
								),
							),
						),
						'radio_cb_size'            => array(
							'type'    => 'unit',
							'label'   => __( 'Size', 'bb-form-styler' ),
							'default' => '15',
							'slider'  => true,
							'units'   => array( 'px' ),
							'class'   => 'bb-gf-input input-small',
						),
						'radio_cb_color'           => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-form-styler' ),
							'default'     => 'dddddd',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'radio_cb_checked_color'   => array(
							'type'        => 'color',
							'label'       => __( 'Checked Color', 'bb-form-styler' ),
							'default'     => '999999',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'radio_cb_border_width'    => array(
							'type'    => 'unit',
							'label'   => __( 'Border Width', 'bb-form-styler' ),
							'default' => '1',
							'slider'  => true,
							'units'   => array( 'px' ),
						),
						'radio_cb_border_color'    => array(
							'type'        => 'color',
							'label'       => __( 'Border Color', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
						),
						'radio_cb_radius'          => array(
							'type'    => 'unit',
							'label'   => __( 'Radio Round Corners', 'bb-form-styler' ),
							'default' => '50',
							'slider'  => true,
							'units'   => array( 'px' ),
						),
						'radio_cb_checkbox_radius' => array(
							'type'    => 'unit',
							'label'   => __( 'Checkbox Round Corners', 'bb-form-styler' ),
							'default' => '0',
							'slider'  => true,
							'units'   => array( 'px' ),
						),
					),
				),
				'file_upload_style' => array(
					'title'     => __( 'File Upload', 'bb-form-styler' ),
					'collapsed' => true,
					'fields'    => array(
						'file_bg_color'           => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input[type=file]',
								'property' => 'background-color',
							),
						),
						'file_text_color'         => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input[type=file]',
								'property' => 'color',
							),
						),
						'file_border_style'       => array(
							'type'    => 'button-group',
							'label'   => __( 'Border Style', 'bb-form-styler' ),
							'default' => 'none',
							'options' => array(
								'none'   => __( 'None', 'bb-form-styler' ),
								'solid'  => __( 'Solid', 'bb-form-styler' ),
								'dashed' => __( 'Dashed', 'bb-form-styler' ),
								'dotted' => __( 'Dotted', 'bb-form-styler' ),
							),
							'preview' => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input[type=file]',
								'property' => 'border-style',
							),
							'toggle'  => array(
								'solid'  => array(
									'fields' => array( 'file_border_width', 'file_border_color' ),
								),
								'dashed' => array(
									'fields' => array( 'file_border_width', 'file_border_color' ),
								),
								'dotted' => array(
									'fields' => array( 'file_border_width', 'file_border_color' ),
								),
							),
						),
						'file_border_width'       => array(
							'type'    => 'unit',
							'label'   => __( 'Border Width', 'bb-form-styler' ),
							'slider'  => true,
							'units'   => array( 'px' ),
							'default' => '',
							'preview' => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input[type=file]',
								'property' => 'border-width',
								'unit'     => 'px',
							),
						),
						'file_border_color'       => array(
							'type'        => 'color',
							'label'       => __( 'Border Color', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input[type=file]',
								'property' => 'border-color',
							),
						),
						'file_horizontal_padding' => array(
							'type'    => 'unit',
							'label'   => __( 'Horizontal Padding', 'bb-form-styler' ),
							'slider'  => true,
							'units'   => array( 'px' ),
							'default' => '',
							'preview' => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'selector' => '.gform_wrapper .gfield input[type=file]',
										'property' => 'padding-left',
										'unit'     => 'px',
									),
									array(
										'selector' => '.gform_wrapper .gfield input[type=file]',
										'property' => 'padding-right',
										'unit'     => 'px',
									),
								),
							),
						),
						'file_vertical_padding'   => array(
							'type'    => 'unit',
							'label'   => __( 'Vertical Padding', 'bb-form-styler' ),
							'slider'  => true,
							'units'   => array( 'px' ),
							'default' => '',
							'preview' => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'selector' => '.gform_wrapper .gfield input[type=file]',
										'property' => 'padding-top',
										'unit'     => 'px',
									),
									array(
										'selector' => '.gform_wrapper .gfield input[type=file]',
										'property' => 'padding-bottom',
										'unit'     => 'px',
									),
								),
							),
						),
					),
				),
			),
		),
		'button_style'    => array(
			'title'    => __( 'Button', 'bb-form-styler' ),
			'sections' => array(
				'button_bg'       => array(
					'title'  => __( 'Colors', 'bb-form-styler' ),
					'fields' => array(
						'button_text_color'       => array(
							'type'        => 'color',
							'label'       => __( 'Text Color', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gform-button, .gform_wrapper .gform_footer .gform_button, .gform_wrapper .gform_page_footer .button',
								'property' => 'color',
							),
						),
						'button_hover_text_color' => array(
							'type'        => 'color',
							'label'       => __( 'Text Color Hover', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gform-button:hover, .gform_wrapper .gform_footer .gform_button:hover, .gform_wrapper .gform_page_footer .button:hover',
								'property' => 'color',
							),
						),
						'button_bg_color'         => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gform-button, .gform_wrapper .gform_footer .gform_button, .gform_wrapper .gform_page_footer .button',
								'property' => 'background-color',
							),
						),
						'button_hover_bg_color'   => array(
							'type'        => 'color',
							'label'       => __( 'Background Color Hover', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gform-button:hover, .gform_wrapper .gform_footer .gform_button:hover, .gform_wrapper .gform_page_footer .button:hover',
								'property' => 'background-color',
							),
						),
					),
				),
				'button_border'   => array(
					'title'     => __( 'Border & Shadow', 'bb-form-styler' ),
					'collapsed' => true,
					'fields'    => array(
						'button_border_group' => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gform-button, .gform_wrapper .gform_footer .gform_button, .gform_wrapper .gform_page_footer .button',
							),
						),
					),
				),
				'button_settings' => array( // Section
					'title'     => __( 'Size & Alignment', 'bb-form-styler' ), // Section Title
					'collapsed' => true,
					'fields'    => array( // Section Fields
						'button_width'        => array(
							'type'    => 'button-group',
							'label'   => __( 'Full Width', 'bb-form-styler' ),
							'default' => 'false',
							'options' => array(
								'true'  => __( 'Yes', 'bb-form-styler' ),
								'false' => __( 'No', 'bb-form-styler' ),
							),
							'toggle'  => array(
								'false' => array(
									'fields' => array( 'button_width_size', 'button_alignment' ),
								),
							),
						),
						'button_custom_width' => array(
							'type'    => 'unit',
							'label'   => __( 'Custom Width', 'bb-form-styler' ),
							'default' => '',
							'slider'  => true,
							'responsive'  => true,
							'units'   => array( 'px' ),
						),
						'button_alignment'    => array(
							'type'    => 'align',
							'label'   => __( 'Button Alignment', 'bb-form-styler' ),
							'default' => 'left',
						),
					),
				),
				'button_corners'  => array(
					'title'     => __( 'Corners & Padding', 'bb-form-styler' ),
					'collapsed' => true,
					'fields'    => array(
						'button_padding_top_bottom' => array(
							'type'       => 'unit',
							'label'      => __( 'Top/Bottom Padding', 'bb-form-styler' ),
							'slider'     => true,
							'units'      => array( 'px' ),
							'default'    => '',
							'preview'    => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'selector' => '.gform_wrapper .gform-button, .gform_wrapper .gform_footer .gform_button, .gform_wrapper .gform_page_footer .button',
										'property' => 'padding-top',
										'unit'     => 'px',
									),
									array(
										'selector' => '.gform_wrapper .gform-button, .gform_wrapper .gform_footer .gform_button, .gform_wrapper .gform_page_footer .button',
										'property' => 'padding-bottom',
										'unit'     => 'px',
									),
								),
							),
							'responsive' => true,
						),
						'button_padding_left_right' => array(
							'type'       => 'unit',
							'label'      => __( 'Left/Right Padding', 'bb-form-styler' ),
							'slider'     => true,
							'units'      => array( 'px' ),
							'default'    => '',
							'preview'    => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'selector' => '.gform_wrapper .gform-button, .gform_wrapper .gform_footer .gform_button, .gform_wrapper .gform_page_footer .button',
										'property' => 'padding-left',
										'unit'     => 'px',
									),
									array(
										'selector' => '.gform_wrapper .gform-button, .gform_wrapper .gform_footer .gform_button, .gform_wrapper .gform_page_footer .button',
										'property' => 'padding-right',
										'unit'     => 'px',
									),
								),
							),
							'responsive' => true,
						),
					),
				),
			),
		),
		'error_style'     => array(
			'title'    => __( 'Errors', 'bb-form-styler' ),
			'sections' => array(
				'form_error_styling' => array( // Section
					'title'  => __( 'Errors Style', 'bb-form-styler' ), // Section Title
					'fields' => array( // Section Fields
						'validation_error'              => array(
							'type'    => 'button-group',
							'label'   => __( 'Submission Error', 'bb-form-styler' ),
							'default' => 'block',
							'options' => array(
								'block' => __( 'Show', 'bb-form-styler' ),
								'none'  => __( 'Hide', 'bb-form-styler' ),
							),
							'toggle'  => array(
								'block' => array(
									'fields'   => array( 'validation_error_color' ),
									'sections' => array( 'errors_typography' ),
								),
							),
						),
						'validation_error_color'        => array(
							'type'        => 'color',
							'label'       => __( 'Submission Error Text Color', 'bb-form-styler' ),
							'default'     => '790000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .validation_error',
								'property' => 'color',
							),
						),
						'validation_error_border_color' => array(
							'type'        => 'color',
							'label'       => __( 'Error Border Color', 'bb-form-styler' ),
							'default'     => '790000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .validation_error',
								'property' => 'border-color',
							),
						),
						'form_error_field_background_color' => array(
							'type'        => 'color',
							'label'       => __( 'Error Field Background Color', 'bb-form-styler' ),
							'default'     => 'ffdfe0',
							'show_reset'  => true,
							'show_alpha'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield.gfield_error',
								'property' => 'color',
							),
						),
						'form_error_field_label_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Error Field Label Color', 'bb-form-styler' ),
							'default'     => '790000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield.gfield_error .gfield_label',
								'property' => 'color',
							),
						),
						'form_error_input_border_color' => array(
							'type'        => 'color',
							'label'       => __( 'Error Field Input Border Color', 'bb-form-styler' ),
							'default'     => '790000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield_error .ginput_container input, .gform_wrapper .gfield_error .ginput_container select, .gform_wrapper .gfield_error .ginput_container textarea',
								'property' => 'color',
							),
						),
						'form_error_input_border_width' => array(
							'type'    => 'unit',
							'label'   => __( 'Error Field Input Border Width', 'bb-form-styler' ),
							'slider'  => true,
							'units'   => array( 'px' ),
							'default' => '1',
							'preview' => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield_error .ginput_container input, .gform_wrapper .gfield_error .ginput_container select, .gform_wrapper .gfield_error .ginput_container textarea',
								'property' => 'border-width',
								'unit'     => 'px',
							),
						),
						'validation_message'            => array(
							'type'    => 'button-group',
							'label'   => __( 'Error Field Message', 'bb-form-styler' ),
							'default' => 'block',
							'options' => array(
								'block' => __( 'Show', 'bb-form-styler' ),
								'none'  => __( 'Hide', 'bb-form-styler' ),
							),
							'toggle'  => array(
								'block' => array(
									'fields' => array( 'validation_message_color' ),
								),
							),
						),
						'validation_message_color'      => array(
							'type'        => 'color',
							'label'       => __( 'Error Field Message Color', 'bb-form-styler' ),
							'default'     => '790000',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield_error .validation_message',
								'property' => 'color',
							),
						),
					),
				),
			),
		),
		'messages_style'  => array(
			'title'    => __( 'Messages', 'bb-form-styler' ),
			'sections' => array(
				'message_style' => array(
					'title'  => __( 'Success Message', 'bb-form-styler' ),
					'fields' => array(
						'message_bg_color'     => array(
							'type'       => 'color',
							'label'      => __( 'Background Color', 'bb-form-styler' ),
							'show_reset' => true,
							'show_alpha' => true,
							'connections' => array( 'color' ),
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_confirmation_wrapper',
								'property' => 'background-color',
							),
						),
						'message_color'        => array(
							'type'       => 'color',
							'label'      => __( 'Text Color', 'bb-form-styler' ),
							'show_reset' => true,
							'connections' => array( 'color' ),
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_confirmation_wrapper .gform_confirmation_message',
								'property' => 'color',
							),
						),
						'message_border_group' => array(
							'type'       => 'border',
							'label'      => __( 'Border Style', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_confirmation_wrapper',
							),
						),
						'message_padding'      => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-form-styler' ),
							'slider'     => true,
							'units'      => array( 'px' ),
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_confirmation_wrapper',
								'property' => 'padding',
								'unit'     => 'px',
							),
							'responsive' => true,
						),
						'message_typography'   => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_confirmation_wrapper .gform_confirmation_message',
							),
						),
					),
				),
			),
		),
		'form_typography' => array( // Tab
			'title'    => __( 'Typography', 'bb-form-styler' ), // Tab title
			'sections' => array( // Tab Sections
				'title_typography'       => array( // Section
					'title'  => __( 'Title', 'bb-form-styler' ), // Section Title
					'fields' => array( // Section Fields
						'title_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_title, .bbfs-form-title',
							),
						),
						'title_color'      => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_title, .bbfs-form-title',
								'property' => 'color',
							),
						),
					),
				),
				'description_typography' => array(
					'title'     => __( 'Description', 'bb-form-styler' ),
					'collapsed' => true,
					'fields'    => array(
						'description_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_description, .bbfs-form-description',
							),
						),
						'description_color'      => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-form-styler' ),
							'default'     => '',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_description, .bbfs-form-description',
								'property' => 'color',
							),
						),
					),
				),
				'section_typography'     => array(
					'title'     => __( 'Sections', 'bb-form-styler' ),
					'collapsed' => true,
					'fields'    => array(
						'section_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper h2.gsection_title, .gform_wrapper h3.gsection_title',
							),
						),
						'section_text_color' => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-form-styler' ),
							'default'     => '333333',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper h2.gsection_title, .gform_wrapper h3.gsection_title',
								'property' => 'color',
							),
						),
					),
				),
				'label_typography'       => array( // Section
					'title'     => __( 'Label', 'bb-form-styler' ), // Section Title
					'collapsed' => true,
					'fields'    => array( // Section Fields
						'label_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Label Typography', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield .gfield_label',
							),
						),
						'radio_checkbox_font_size' => array(
							'type'    => 'unit',
							'label'   => __( 'Radio & Checkbox Label Font Size', 'bb-form-styler' ),
							'units'   => array( 'px' ),
							'slider'  => true,
							'responsive'  => true,
							'default' => '',
							'preview' => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper ul.gfield_radio li label, .gform_wrapper ul.gfield_checkbox li label',
								'property' => 'font-size',
								'unit'     => 'px',
							),
						),
						'input_desc_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Input Description Typography', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield .gfield_description',
							),
						),
					),
				),
				'input_typography'       => array( // Section
					'title'     => __( 'Input', 'bb-form-styler' ), // Section Title
					'collapsed' => true,
					'fields'    => array( // Section Fields
						'input_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Input Typography', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gfield input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), .gform_wrapper .gfield select, .gform_wrapper .gfield textarea',
							),
						),
					),
				),
				'button_typography'      => array( // Section
					'title'     => __( 'Button', 'bb-form-styler' ), // Section Title
					'collapsed' => true,
					'fields'    => array( // Section Fields
						'button_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .gform_footer .gform_button, .gform_wrapper .gform_page_footer .button',
							),
						),
					),
				),
				'errors_typography'      => array( // Section
					'title'     => __( 'Error', 'bb-form-styler' ), // Section Title
					'collapsed' => true,
					'fields'    => array( // Section Fields
						'validation_error_font_size' => array(
							'type'    => 'unit',
							'label'   => __( 'Error Description Font Size', 'bb-form-styler' ),
							'units'   => array( 'px' ),
							'slider'  => true,
							'default' => '',
							'preview' => array(
								'type'     => 'css',
								'selector' => '.gform_wrapper .validation_error',
								'property' => 'font-size',
								'unit'     => 'px',
							),
						),
					),
				),
			),
		),
	)
);
