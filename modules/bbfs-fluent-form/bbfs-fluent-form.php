<?php

/**
 * @class BBFS_Fluent_Form_Module
 */
class BBFS_Fluent_Form_Module extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          => __( 'WP Fluent Forms', 'bb-form-styler' ),
			'description'   => __( 'A module for WP Fluent Forms.', 'bb-form-styler' ),
			'category'      => BBFS_Helpers::get_modules_cat( 'form_style' ),
			'dir'           => BBFS_DIR . 'modules/bbfs-fluent-form/',
			'url'           => BBFS_URL . 'modules/bbfs-fluent-form/',
			'editor_export' => true, // Defaults to true and can be omitted.
			'enabled'       => true, // Defaults to true and can be omitted.
		));
	}

	// Get all forms of WP Fluent Forms plugin
	public static function get_fluent_forms() {
		$options = array();

		if ( ! BBFS_Helpers::is_builder_request() ) {
			return $options;
		}

		if ( function_exists( 'wpFluentForm' ) ) {
			global $wpdb;
			$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}fluentform_forms" );
			if ( $result ) {
				$options[0] = esc_html__( 'Select a form', 'bb-form-styler' );
				foreach ( $result as $form ) {
					$options[ $form->id ] = $form->title;
				}
			} else {
				$options[0] = esc_html__( 'No forms found!', 'bb-form-styler' );
			}
		}

		return $options;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'BBFS_Fluent_Form_Module',
	array(
		'form'            => array( // Tab
			'title'         => __( 'General', 'bb-form-styler' ), // Tab title
			'sections'      => array( // Tab Sections
				'select_form'       => array( // Section
					'title'         => '', // Section Title
					'fields'        => array( // Section Fields
						'select_form_field' => array(
							'type'          => 'select',
							'label'         => __( 'Select Form', 'bb-form-styler' ),
							'default'       => '',
							'options'       => BBFS_Fluent_Form_Module::get_fluent_forms(),
							'connections'   => array( 'string' )
						),
					),
				),
				'form_general_setting'  => array(
					'title' => __( 'Settings', 'bb-form-styler' ),
					'fields'    => array(
						'form_custom_title_desc'   => array(
							'type'          => 'button-group',
							'label'         => __( 'Custom Title & Description', 'bb-form-styler' ),
							'default'       => 'no',
							'options'       => array(
								'yes'      => __( 'Yes', 'bb-form-styler' ),
								'no'     => __( 'No', 'bb-form-styler' ),
							),
							'toggle' => array(
								'yes'      => array(
									'fields'  => array( 'custom_title', 'custom_description' ),
									'sections'  => array( 'title_style', 'description_style' ),
								),
							),
						),
						'custom_title'      => array(
							'type'          => 'text',
							'label'         => __( 'Custom Title', 'bb-form-styler' ),
							'default'       => '',
							'description'   => '',
							'connections'   => array( 'string' ),
							'preview'       => array(
								'type'      => 'text',
								'selector'  => '.bbfs-form-title',
							),
						),
						'custom_description'    => array(
							'type'              => 'textarea',
							'label'             => __( 'Custom Description', 'bb-form-styler' ),
							'default'           => '',
							'placeholder'       => '',
							'rows'              => '6',
							'connections'   => array( 'string', 'html' ),
							'preview'           => array(
								'type'          => 'text',
								'selector'      => '.bbfs-form-description',
							),
						),
					),
				),
			),
		),
		'style'           => array( // Tab
			'title'         => __( 'Style', 'bb-form-styler' ), // Tab title
			'sections'      => array( // Tab Sections
				'form_background'      => array( // Section
					'title'         => __( 'Form Background', 'bb-form-styler' ), // Section Title
					'fields'        => array( // Section Fields
						'form_bg_type'      => array(
							'type'          => 'button-group',
							'label'         => __( 'Background Type', 'bb-form-styler' ),
							'default'       => 'color',
							'options'       => array(
								'color'   => __( 'Color', 'bb-form-styler' ),
								'image'     => __( 'Image', 'bb-form-styler' ),
							),
							'toggle'    => array(
								'color' => array(
									'fields'    => array( 'form_bg_color' ),
								),
								'image' => array(
									'fields'    => array( 'form_bg_image', 'form_bg_size', 'form_bg_repeat', 'form_bg_overlay' ),
								),
							),
						),
						'form_bg_color'     => array(
							'type'          => 'color',
							'label'         => __( 'Background Color', 'bb-form-styler' ),
							'default'       => '',
							'show_reset'    => true,
							'show_alpha'	=> true,
							'connections'	=> array( 'color' ),
							'preview'       => array(
								'type'      => 'css',
								'selector'  => '.bbfs-fluent-form-content',
								'property'  => 'background-color'
							),
						),
						'form_bg_image'     => array(
							'type'              => 'photo',
							'label'         => __( 'Background Image', 'bb-form-styler' ),
							'default'       => '',
							'show_remove'	=> true,
							'connections'   => array( 'photo' ),
							'preview'       => array(
								'type'      => 'css',
								'selector'  => '.bbfs-fluent-form-content',
								'property'  => 'background-image'
							),
						),
						'form_bg_size'      => array(
							'type'          => 'button-group',
							'label'         => __( 'Background Size', 'bb-form-styler' ),
							'default'       => 'cover',
							'options'       => array(
								'contain'   => __( 'Contain', 'bb-form-styler' ),
								'cover'     => __( 'Cover', 'bb-form-styler' ),
							),
						),
						'form_bg_repeat'    => array(
							'type'          => 'button-group',
							'label'         => __( 'Background Repeat', 'bb-form-styler' ),
							'default'       => 'no-repeat',
							'options'       => array(
								'repeat-x'      => __( 'Repeat X', 'bb-form-styler' ),
								'repeat-y'      => __( 'Repeat Y', 'bb-form-styler' ),
								'no-repeat'     => __( 'No Repeat', 'bb-form-styler' ),
							),
						),
						'form_bg_overlay'     => array(
							'type'          => 'color',
							'label'         => __( 'Background Overlay Color', 'bb-form-styler' ),
							'default'       => '000000',
							'show_reset'    => true,
							'show_alpha'	=> true,
							'connections'	=> array( 'color' ),
						),
					),
				),
				'form_border_settings'      => array( // Section
					'title'         => __( 'Form Border', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'        => array( // Section Fields
						'form_border'	=> array(
							'type'          => 'border',
							'label'         => __( 'Border & Padding', 'bb-form-styler' ),
							'responsive'	=> true,
							'preview'   	=> array(
								'type'  		=> 'css',
								'selector'  	=> '.bbfs-fluent-form-content',
								'property'  	=> 'border',
							),
						),
						'form_padding'    => array(
							'type'				=> 'dimension',
							'label'				=> __( 'Padding', 'bb-form-styler' ),
							'default'			=> '15',
							'units'				=> array( 'px' ),
							'slider'			=> true,
							'responsive'		=> true,
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.bbfs-fluent-form-content',
								'property'			=> 'padding',
								'unit'				=> 'px',
							),
						),
					),
				),
				'title_style' => array( // Section
					'title' => __( 'Title', 'bb-form-styler' ),
					'collapsed'		=> true,
					'fields'    => array(
						'title_color'       => array(
							'type'          => 'color',
							'label'         => __( 'Color', 'bb-form-styler' ),
							'default'       => '',
							'show_reset'    => true,
							'connections'	=> array( 'color' ),
							'preview'       => array(
								'type'      => 'css',
								'selector'  => '.bbfs-fluent-form-content .bbfs-form-title',
								'property'  => 'color',
							),
						),
						'title_margin'	=> array(
							'type'				=> 'dimension',
							'label'				=> __( 'Margin', 'bb-form-styler' ),
							'default'			=> '10',
							'units'				=> array( 'px' ),
							'slider'			=> true,
							'responsive'		=> true,
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.bbfs-fluent-form-content .bbfs-form-title',
								'property'			=> 'margin',
								'unit'				=> 'px',
							),
						),
					),
				),
				'description_style' => array( // Section
					'title' => __( 'Description', 'bb-form-styler' ),
					'collapsed'		=> true,
					'fields'    => array(
						'description_color' => array(
							'type'          => 'color',
							'label'         => __( 'Color', 'bb-form-styler' ),
							'default'       => '',
							'show_reset'    => true,
							'connections'	=> array( 'color' ),
							'preview'       => array(
								'type'      => 'css',
								'selector'  => '.bbfs-fluent-form-content .bbfs-form-description',
								'property'  => 'color',
							),
						),
						'description_margin'	=> array(
							'type'				=> 'dimension',
							'label'				=> __( 'Margin', 'bb-form-styler' ),
							'default'			=> '10',
							'units'				=> array( 'px' ),
							'slider'			=> true,
							'responsive'		=> true,
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.bbfs-fluent-form-content .bbfs-form-description',
								'property'			=> 'margin',
								'unit'				=> 'px',
							),
						),
					),
				),
				'label_style'	=> array(
					'title'	=> __( 'Labels', 'bb-form-styler' ),
					'collapsed'	=> true,
					'fields'	=> array(
						'display_labels'   => array(
							'type'         => 'button-group',
							'label'        => __( 'Labels', 'bb-form-styler' ),
							'default'      => 'inline-block',
							'options'      => array(
								'inline-block'    => __( 'Show', 'bb-form-styler' ),
								'none'     => __( 'Hide', 'bb-form-styler' ),
							),
						),
						'label_color'  => array(
							'type'          => 'color',
							'label'         => __( 'Color', 'bb-form-styler' ),
							'default'       => '',
							'show_reset'    => true,
							'connections'	=> array( 'color' ),
							'preview'       => array(
								'type'      => 'css',
								'selector'  => '.bbfs-fluent-form-content .ff-el-input--label label, .bbfs-fluent-form-content .fluentform .ff-el-form-check-label',
								'property'  => 'color',
							),
						),
					),
				),
				'section_field_setting'	=> array( // Section
					'title' 	=> __( 'Section Field', 'bb-form-styler' ),
					'collapsed'	=> true,
					'fields'    => array(
						'section_field_bg_color'     => array(
							'type'          => 'color',
							'label'         => __( 'Background Color', 'bb-form-styler' ),
							'default'       => '',
							'show_reset'    => true,
							'show_alpha'    => true,
							'connections'	=> array( 'color' ),
							'preview'       => array(
								'type'      => 'css',
								'selector'  => '.bbfs-fluent-form-content .ff-el-section-break',
								'property'  => 'background-color',
							),
						),
						'section_field_border'	=> array(
							'type'          => 'border',
							'label'         => __( 'Border', 'bb-form-styler' ),
							'responsive'	=> true,
							'preview'   	=> array(
								'type'  		=> 'css',
								'selector'  	=> '.bbfs-fluent-form-content .ff-el-section-break',
								'property'  	=> 'border',
							),
						),
						'section_field_margin'	=> array(
							'type'				=> 'dimension',
							'label'				=> __( 'Margin', 'bb-form-styler' ),
							'default'			=> '0',
							'units'				=> array( 'px' ),
							'slider'			=> true,
							'responsive'		=> true,
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.bbfs-fluent-form-content .ff-el-section-break',
								'property'			=> 'margin',
								'unit'				=> 'px',
							),
						),
						'section_field_padding'	=> array(
							'type'				=> 'dimension',
							'label'				=> __( 'Padding', 'bb-form-styler' ),
							'default'			=> '0',
							'units'				=> array( 'px' ),
							'slider'			=> true,
							'responsive'		=> true,
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.bbfs-fluent-form-content .ff-el-section-break',
								'property'			=> 'padding',
								'unit'				=> 'px',
							),
						),
					),
				),
			),
		),
		'input_style_t'   => array(
			'title' => __( 'Inputs', 'bb-form-styler' ),
			'sections'  => array(
				'input_field_colors'      => array( // Section
					'title'         => __( 'Colors', 'bb-form-styler' ), // Section Title
					'fields'        => array( // Section Fields
						'input_field_text_color'    => array(
							'type'                  => 'color',
							'label'                 => __( 'Text Color', 'bb-form-styler' ),
							'default'               => '',
							'show_reset'            => true,
							'connections'			=> array( 'color' ),
							'preview'               => array(
								'type'                  => 'css',
								'selector'              => '.bbfs-fluent-form-content .fluentform .ff-el-form-control',
								'property'              => 'color',
							),
						),
						'input_field_bg_color'      => array(
							'type'                  => 'color',
							'label'                 => __( 'Background Color', 'bb-form-styler' ),
							'default'               => '',
							'show_reset'            => true,
							'show_alpha'			=> true,
							'connections'			=> array( 'color' ),
							'preview'               => array(
								'type'              => 'css',
								'selector'          => '.bbfs-fluent-form-content .fluentform .ff-el-form-control',
								'property'          => 'background-color',
							),
						),
					),
				),
				'input_border_settings'      => array( // Section
					'title'         => __( 'Border', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'        => array( // Section Fields
						'input_border'	=> array(
							'type'			=> 'border',
							'label'			=> __( 'Border', 'bb-form-styler' ),
							'preview'		=> array(
								'type'			=> 'css',
								'selector'		=> '.bbfs-fluent-form-content .fluentform .ff-el-form-control',
							),
						),
						'input_field_focus_color'      => array(
							'type'                  => 'color',
							'label'                 => __( 'Focus Border Color', 'bb-form-styler' ),
							'default'               => '',
							'show_reset'            => true,
							'connections'			=> array( 'color' ),
							'preview'               => array(
								'type'              => 'css',
								'selector'          => '.bbfs-fluent-form-content .fluentform .ff-el-form-control:focus',
								'property'          => 'border-color',
							),
						),
					),
				),
				'input_size_alignment'      => array( // Section
					'title'         => __( 'Size & Alignment', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'        => array( // Section Fields
						'input_field_width'     => array(
							'type'              => 'button-group',
							'label'             => __( 'Full Width', 'bb-form-styler' ),
							'default'           => 'false',
							'options'           => array(
								'true'          => __( 'Yes', 'bb-form-styler' ),
								'false'         => __( 'No', 'bb-form-styler' ),
							),
						),
						'input_field_height'    => array(
							'type'                    => 'unit',
							'label'                   => __( 'Input Height', 'bb-form-styler' ),
							'default'                 => '',
							'units'					  => array( 'px' ),
							'slider'				  => true,
							'preview'                 => array(
								'type'                => 'css',
								'selector'            => '.bbfs-fluent-form-content .fluentform .ff-el-form-control',
								'property'            => 'height',
								'unit'                => 'px',
							),
						),
						'input_textarea_height'    => array(
							'type'                    => 'unit',
							'label'                   => __( 'Textarea Height', 'bb-form-styler' ),
							'default'                 => '',
							'units'					  => array( 'px' ),
							'slider'				  => true,
							'preview'                 => array(
								'type'                => 'css',
								'selector'            => '.bbfs-fluent-form-content .fluentform textarea.ff-el-form-control',
								'property'            => 'height',
								'unit'                => 'px',
							),
						),
					),
				),
				'input_general_style'      => array( // Section
					'title'         => __( 'General', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'        => array( // Section Fields
						'input_field_padding'    => array(
							'type'				=> 'dimension',
							'label'				=> __( 'Padding', 'bb-form-styler' ),
							'default'			=> '10',
							'units'				=> array( 'px' ),
							'slider'			=> true,
							'responsive'		=> true,
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.bbfs-fluent-form-content .fluentform .ff-el-form-group:not([data-type="address"]) .ff-el-form-control',
								'property'			=> 'padding',
								'unit'				=> 'px',
							),
						),
						'input_field_margin'    => array(
							'type'              => 'unit',
							'label'             => __( 'Margin Bottom', 'bb-form-styler' ),
							'default'           => '10',
							'units'				=> array( 'px' ),
							'slider'			=> true,
							'preview'           => array(
								'type'          => 'css',
								'selector'      => '.bbfs-fluent-form-content .fluentform .ff-el-form-group:not([data-type="address"]) .ff-field_container',
								'property'      => 'margin-bottom',
								'unit'          => 'px',
							),
						),
					),
				),
				'address_block'          => array(
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
								'selector' => '.bbfs-fluent-form-content .ff-el-form-group[data-type="address"]',
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
								'selector' => '.bbfs-fluent-form-content .ff-el-form-group[data-type="address"]',
								'property' => 'margin-bottom',
								'unit'     => 'px',
							),
						),
					),
				),
				'placeholder_style'      => array( // Section
					'title'         => __( 'Placeholder', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'        => array( // Section Fields
						'input_placeholder_display' 	=> array(
							'type'          => 'button-group',
							'label'         => __( 'Show Placeholder', 'bb-form-styler' ),
							'default'       => 'block',
							'options'		=> array(
								'block'	=> __( 'Yes', 'bb-form-styler' ),
								'none'	=> __( 'No', 'bb-form-styler' ),
							),
							'toggle' => array(
								'block' => array(
									'fields' => array( 'input_placeholder_color' ),
								),
							),
						),
						'input_placeholder_color'  => array(
							'type'                  => 'color',
							'label'                 => __( 'Color', 'bb-form-styler' ),
							'default'               => '',
							'show_reset'            => true,
							'connections'			=> array( 'color' ),
							'preview'               => array(
								'type'              => 'css',
								'selector'          => '.bbfs-fluent-form-content .fluentform .ff-el-form-control::-webkit-input-placeholder',
								'property'          => 'color',
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
							'class'   => '.bbfs-fluent-form-content .fluentform input[type=checkbox], .bbfs-fluent-form-content .fluentform input[type=radio]',
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
			),
		),
		'button_style'    => array(
			'title'    => __( 'Button', 'bb-form-styler' ),
			'sections' => array(
				'button_colors'          => array(
					'title'  => __( 'Colors', 'bb-form-styler' ), // Section Title
					'fields' => array( // Section Fields
						'button_text_color'             => array(
							'type'       	=> 'color',
							'label'     	=> __( 'Text Color', 'bb-form-styler' ),
							'default'    	=> '',
							'show_reset'	=> true,
							'connections'	=> array( 'color' ),
							'preview'	=> array(
								'type'		=> 'css',
								'selector'	=> '.bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button',
								'property'	=> 'color',
							),
						),
						'button_text_color_hover'       => array(
							'type'       	=> 'color',
							'label'     	=> __( 'Text Hover Color', 'bb-form-styler' ),
							'default'    	=> '',
							'show_reset'	=> true,
							'connections'	=> array( 'color' ),
							'preview'	=> array(
								'type'		=> 'css',
								'selector'	=> '.bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button:hover',
								'property'	=> 'color',
							),
						),
						'button_bg_color'               => array(
							'type'       	=> 'color',
							'label'     	=> __( 'Background Color', 'bb-form-styler' ),
							'default'    	=> '',
							'show_reset'	=> true,
							'show_alpha'	=> true,
							'connections'	=> array( 'color' ),
							'preview'	=> array(
								'type'		=> 'css',
								'selector'	=> '.bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button',
								'property'	=> 'background-color',
							),
						),
						'button_background_color_hover' => array(
							'type'       	=> 'color',
							'label'     	=> __( 'Background Hover Color', 'bb-form-styler' ),
							'default'    	=> '',
							'show_reset'	=> true,
							'show_alpha'	=> true,
							'connections'	=> array( 'color' ),
							'preview'	=> array(
								'type'		=> 'css',
								'selector'	=> '.bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button:hover',
								'property'	=> 'background-color',
							),
						),
					),
				),
				'button_border_settings' => array(
					'title'             => __( 'Border', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'            => array( // Section Fields
						'button_border'	=> array(
							'type'          => 'border',
							'label'         => __( 'Border', 'bb-form-styler' ),
							'responsive'	=> true,
							'preview'   	=> array(
								'type'  		=> 'css',
								'selector'  	=> '.bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button',
								'property'  	=> 'border',
							),
						),
					),
				),
				'button_size_settings'   => array(
					'title'             => __( 'Size & Alignment', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'            => array( // Section Fields
						'button_width'  => array(
							'type'      => 'button-group',
							'label'     => __( 'Full Width', 'bb-form-styler' ),
							'default'   => 'false',
							'options'   => array(
								'true'  => __( 'Yes', 'bb-form-styler' ),
								'false' => __( 'No', 'bb-form-styler' ),
							),
							'toggle'    => array(
								'false' => array(
									'fields'    => array( 'button_alignment' ),
								),
							),
						),
						'button_alignment'  => array(
							'type'          => 'align',
							'label'         => __( 'Alignment', 'bb-form-styler' ),
							'default'       => 'left',
							'responsive'	=> true,
							'preview'            => array(
								'type'           => 'css',
								'selector'       => '.bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button',
								'property'       => 'float',
							),
						),
					),
				),
				'button_corners_padding' => array( // Section
					'title'             => __( 'Padding', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'            => array( // Section Fields
						'button_padding'    => array(
							'type'				=> 'dimension',
							'label'				=> __( 'Padding', 'bb-form-styler' ),
							'default'			=> '',
							'units'				=> array( 'px' ),
							'slider'			=> true,
							'responsive'		=> true,
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button',
								'property'			=> 'padding',
								'unit'				=> 'px',
							),
						),
					),
				),
			),
		),
		'Messages_style'  => array(
			'title' => __( 'Messages', 'bb-form-styler' ),
			'sections'  => array(
				'form_error_styling'    => array( // Section
					'title'             => __( 'Errors', 'bb-form-styler' ), // Section Title
					'fields'            => array( // Section Fields
						'error_message'   => array(
							'type'             => 'button-group',
							'label'            => __( 'Error Messages', 'bb-form-styler' ),
							'default'          => 'block',
							'options'          => array(
								'block'        => __( 'Show', 'bb-form-styler' ),
								'none'         => __( 'Hide', 'bb-form-styler' ),
							),
							'toggle'    => array(
								'block' => array(
									'fields'    => array( 'validation_message_color' ),
									'sections'  => array( 'errors_typography' ),
								),
							),
						),
						'error_message_color'    => array(
							'type'                    => 'color',
							'label'                   => __( 'Text Color', 'bb-form-styler' ),
							'default'                 => '',
							'connections'				=> array( 'color' ),
							'preview'                 => array(
								'type'                => 'css',
								'selector'            => '.bbfs-fluent-form-content .ff-el-is-error .error',
								'property'            => 'color',
							),
						),
						'error_input_field_border_color'    => array(
							'type'                    => 'color',
							'label'                   => __( 'Border Color', 'bb-form-styler' ),
							'default'                 => '',
							'connections'				=> array( 'color' ),
							'preview'                 => array(
								'type'                => 'css',
								'selector'            => '.bbfs-fluent-form-content .ff-el-is-error .ff-el-form-control',
								'property'            => 'color',
							),
						),
						'error_input_field_border_width'    => array(
							'type'				=> 'unit',
							'label'				=> __( 'Border Width', 'bb-form-styler' ),
							'default'			=> '1',
							'slider'			=> true,
							'preview'			=> array(
								'type'				=> 'css',
								'selector'			=> '.bbfs-fluent-form-content .ff-el-is-error .ff-el-form-control',
								'property'			=> 'border-width',
							),
						),
					),
				),
				'form_success_styling'    => array( // Section
					'title'             => __( 'Success Message', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'            => array( // Section Fields
						'success_message_bg_color'    => array(
							'type'                         => 'color',
							'label'                        => __( 'Background Color', 'bb-form-styler' ),
							'default'                      => '',
							'show_reset'                   => true,
							'show_alpha'				   => true,
							'connections'					=> array( 'color' ),
							'preview'                      => array(
								'type'                     => 'css',
								'selector'                 => '.bbfs-fluent-form-content .ff-message-success',
								'property'                 => 'background-color',
							),
						),
						'success_message_color'    => array(
							'type'                         => 'color',
							'label'                        => __( 'Color', 'bb-form-styler' ),
							'default'                      => '',
							'connections'					=> array( 'color' ),
							'preview'                      => array(
								'type'                     => 'css',
								'selector'                 => '.bbfs-fluent-form-content .ff-message-success',
								'property'                 => 'color',
							),
						),
						'success_message_border'	=> array(
							'type'          => 'border',
							'label'         => __( 'Border', 'bb-form-styler' ),
							'responsive'	=> true,
							'preview'   	=> array(
								'type'  		=> 'css',
								'selector'  	=> '.bbfs-fluent-form-content .ff-message-success',
								'property'  	=> 'border',
							),
						),
					),
				),
			),
		),
		'form_typography' => array( // Tab
			'title'         => __( 'Typography', 'bb-form-styler' ), // Tab title
			'sections'      => array( // Tab Sections
				'title_typography'         => array( // Section
					'title'         => __( 'Title', 'bb-form-styler' ), // Section Title
					'fields'        => array( // Section Fields
						'title_tag'    => array(
							'type'          => 'select',
							'label'         => __('Tag', 'bb-form-styler'),
							'default'       => 'h3',
							'sanitize' => array( 'BBFS_Helpers', 'esc_tags' ),
							'options'       => array(
								'h1'            => 'H1',
								'h2'            => 'H2',
								'h3'            => 'H3',
								'h4'            => 'H4',
								'h5'            => 'H5',
								'h6'            => 'H6',
							)
						),
						'title_typography'	=> array(
							'type'			=> 'typography',
							'label'			=> __( 'Typography', 'bb-form-styler' ),
							'responsive'  	=> true,
							'preview'		=> array(
								'type'			=> 'css',
								'selector'		=> '.bbfs-fluent-form-content .bbfs-form-title',
							),
						),
					),
				),
				'description_typography'   => array(
					'title' => __( 'Description', 'bb-form-styler' ),
					'collapsed'	=> true,
					'fields'    => array(
						'description_typography'	=> array(
							'type'			=> 'typography',
							'label'			=> __( 'Typography', 'bb-form-styler' ),
							'responsive'  	=> true,
							'preview'		=> array(
								'type'			=> 'css',
								'selector'		=> '.bbfs-fluent-form-content .bbfs-form-description',
							),
						),
					),
				),
				'label_typography'         => array( // Section
					'title'         => __( 'Label', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'        => array( // Section Fields
						'label_typography'	=> array(
							'type'			=> 'typography',
							'label'			=> __( 'Typography', 'bb-form-styler' ),
							'responsive'  	=> true,
							'preview'		=> array(
								'type'			=> 'css',
								'selector'		=> '.bbfs-fluent-form-content .ff-el-input--label label',
							),
						),
					),
				),
				'radio_check_typography'   => array( // Section
					'title'     => __( 'Radio & Checkbox Label', 'bb-form-styler' ), // Section Title
					'collapsed' => true,
					'fields'    => array( // Section Fields
						'radio_check_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-form-styler' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.bbfs-fluent-form-content .fluentform .ff-el-form-check-label',
							),
						),
					),
				),
				'input_typography'         => array( // Section
					'title'         => __( 'Input', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'        => array( // Section Fields
						'input_typography'	=> array(
							'type'			=> 'typography',
							'label'			=> __( 'Typography', 'bb-form-styler' ),
							'responsive'  	=> true,
							'preview'		=> array(
								'type'			=> 'css',
								'selector'		=> '.bbfs-fluent-form-content .fluentform .ff-el-form-control',
							),
						),
					),
				),
				'button_typography'        => array( // Section
					'title'         => __( 'Button', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'        => array( // Section Fields
						'button_typography'	=> array(
							'type'			=> 'typography',
							'label'			=> __( 'Typography', 'bb-form-styler' ),
							'responsive'  	=> true,
							'preview'		=> array(
								'type'			=> 'css',
								'selector'		=> '.bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button',
							),
						),
					),
				),
				'section_field_typography' => array( // Section
					'title'         => __( 'Section Field', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'        => array(
						'section_title_typography'	=> array(
							'type'        	   => 'typography',
							'label'       	   => __( 'Title Typography', 'bb-form-styler' ),
							'responsive'  	   => true,
							'preview'          => array(
								'type'         		=> 'css',
								'selector' 		    => '.bbfs-fluent-form-content .ff-el-section-break .ff-el-section-title',
							),
						),
						'section_title_color'  => array(
							'type'                  => 'color',
							'label'                 => __( 'Title Color', 'bb-form-styler' ),
							'default'               => '',
							'show_reset'            => true,
							'connections'			=> array( 'color' ),
							'preview'               => array(
								'type'              => 'css',
								'selector'          => '.bbfs-fluent-form-content .ff-el-section-break .ff-el-section-title',
								'property'          => 'color',
							),
						),
						'section_description_typography'	=> array(
							'type'        	   => 'typography',
							'label'       	   => __( 'Description Typography', 'bb-form-styler' ),
							'responsive'  	   => true,
							'preview'          => array(
								'type'         		=> 'css',
								'selector' 		    => '.bbfs-fluent-form-content .ff-el-section-break',
							),
						),
						'section_description_color'  => array(
							'type'                  => 'color',
							'label'                 => __( 'Description Color', 'bb-form-styler' ),
							'default'               => '',
							'show_reset'            => true,
							'connections'			=> array( 'color' ),
							'preview'               => array(
								'type'              => 'css',
								'selector'          => '.bbfs-fluent-form-content .ff-el-section-break',
								'property'          => 'color',
							),
						),
					),
				),
				'errors_typography'        => array( // Section
					'title'         => __( 'Error', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'        => array( // Section Fields
						'error_typography'	=> array(
							'type'        	   => 'typography',
							'label'       	   => __( 'Typography', 'bb-form-styler' ),
							'responsive'  	   => true,
							'preview'          => array(
								'type'         		=> 'css',
								'selector' 		    => '.bbfs-fluent-form-content .ff-el-section-break .ff-el-section-title',
							),
						),
					),
				),
				'form_success_styling'     => array( // Section
					'title'             => __( 'Success Message', 'bb-form-styler' ), // Section Title
					'collapsed'		=> true,
					'fields'            => array( // Section Fields
						'success_message_typography'	=> array(
							'type'        	   => 'typography',
							'label'       	   => __( 'Typography', 'bb-form-styler' ),
							'responsive'  	   => true,
							'preview'          => array(
								'type'         		=> 'css',
								'selector' 		    => '.bbfs-fluent-form-content .ff-message-success',
							),
						),
					),
				),
			),
		),
	)
);
