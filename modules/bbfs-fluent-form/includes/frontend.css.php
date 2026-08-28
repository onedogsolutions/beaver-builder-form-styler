.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content {
	<?php if ( isset( $settings->form_bg_color ) && ! empty( $settings->form_bg_color ) ) { ?>
	background-color: <?php echo BBFS_Helpers::get_color_value( $settings->form_bg_color ); ?>;
	<?php } ?>
	<?php if ( $settings->form_bg_image ) { ?>
	background-image: url('<?php echo wp_get_attachment_url( absint($settings->form_bg_image) ); ?>');
	<?php } ?>
	<?php if ( $settings->form_bg_size ) { ?>
	background-size: <?php echo $settings->form_bg_size; ?>;
	<?php } ?>
	<?php if ( $settings->form_bg_repeat ) { ?>
	background-repeat: <?php echo $settings->form_bg_repeat; ?>;
	<?php } ?>
}

<?php
	// Form - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'form_border',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content",
	) );

	// Form - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'form_padding',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'form_padding_top',
			'padding-right' 	=> 'form_padding_right',
			'padding-bottom' 	=> 'form_padding_bottom',
			'padding-left' 		=> 'form_padding_left',
		),
	) );
?>

<?php if ( 'image' == $settings->form_bg_image && $settings->form_bg_type ) { ?>
.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content:before {
	content: "";
	display: block;
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	<?php if ( isset( $settings->form_bg_overlay ) && ! empty( $settings->form_bg_overlay ) ) { ?>
	background-color: <?php echo BBFS_Helpers::get_color_value( $settings->form_bg_overlay ); ?>;
	<?php } ?>
}
<?php } ?>

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .ff-el-form-group:not([data-type="address"]) .ff-field_container {
	<?php if ( $settings->input_field_margin >= 0 ) { ?>
	margin-bottom: <?php echo $settings->input_field_margin; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .bbfs-form-title {
	<?php if ( $settings->title_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->title_color ); ?>;
	<?php } ?>
	display: <?php echo ( 'yes' == $settings->form_custom_title_desc ) ? 'block' : 'none'; ?>;
}

<?php
	// Title - Margin
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'title_margin',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .bbfs-form-title",
		'unit'			=> 'px',
		'props'			=> array(
			'margin-top' 		=> 'title_margin_top',
			'margin-right' 		=> 'title_margin_right',
			'margin-bottom' 	=> 'title_margin_bottom',
			'margin-left' 		=> 'title_margin_left',
		),
	) );
	// Title Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'title_typography',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .bbfs-form-title",
	) );
?>

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .bbfs-form-description {
	<?php if ( $settings->description_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->description_color ); ?>;
	<?php } ?>
	display: <?php echo ( 'yes' == $settings->form_custom_title_desc ) ? 'block' : 'none'; ?>;
}

<?php
	// Description - Margin
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'description_margin',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .bbfs-form-description",
		'unit'			=> 'px',
		'props'			=> array(
			'margin-top' 		=> 'description_margin_top',
			'margin-right' 		=> 'description_margin_right',
			'margin-bottom' 	=> 'description_margin_bottom',
			'margin-left' 		=> 'description_margin_left',
		),
	) );
	// Description Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'description_typography',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .bbfs-form-description",
	) );
?>

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .ff-el-input--label label {
	<?php if ( $settings->label_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->label_color ); ?>;
	<?php } ?>
	<?php if ( $settings->display_labels ) { ?>
	display: <?php echo $settings->display_labels; ?>;
	<?php } ?>
}

<?php
	// Label Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'label_typography',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .ff-el-input--label label",
	) );
?>

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .ff-el-form-check-label {
	<?php if ( $settings->label_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->label_color ); ?>;
	<?php } ?>
	<?php if ( is_array( $settings->label_typography ) && isset( $settings->label_typography['font_family'] ) && 'Default' !== $settings->label_typography['font_family'] ) { ?>
		font-family: <?php echo $settings->label_typography['font_family']; ?>;
		font-weight: <?php echo $settings->label_typography['font_weight']; ?>;
	<?php } ?>

}
<?php
// Radio & Checkout Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'     => $settings,
		'setting_name' => 'radio_check_typography',
		'selector'     => ".fl-node-$id .bbfs-fluent-form-content .fluentform .ff-el-form-check-label",
	) );
?>

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .ff-el-form-control,
.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .select2-container--default .select2-selection--multiple {
	<?php if ( $settings->input_field_text_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->input_field_text_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->input_field_bg_color ) && ! empty( $settings->input_field_bg_color ) ) { ?>
	background-color: <?php echo BBFS_Helpers::get_color_value( $settings->input_field_bg_color ); ?>;
	<?php } ?>
}

<?php

	// Input border.
	FLBuilderCSS::border_field_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'input_border',
		'selector'		=> ".fl-node-$id .bbfs-fluent-form-content .fluentform .ff-el-form-control, .fl-node-$id .bbfs-fluent-form-content .select2-container--default .select2-selection--multiple"
	) );

	// Input Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'input_typography',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .fluentform .ff-el-form-control",
	) );

	// Input - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'input_field_padding',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .fluentform .ff-el-form-group:not([data-type=\"address\"]) .ff-el-form-control, .fl-node-$id .bbfs-fluent-form-content .fluentform .ff-el-form-group:not([data-type=\"address\"]) .select2-container--default .select2-selection--multiple",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'input_field_padding_top',
			'padding-right' 	=> 'input_field_padding_right',
			'padding-bottom' 	=> 'input_field_padding_bottom',
			'padding-left' 		=> 'input_field_padding_left',
		),
	) );
?>

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .ff-el-form-control {
	<?php if ( $settings->input_field_height ) { ?>
	height: <?php echo $settings->input_field_height; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform textarea.ff-el-form-control {
	<?php if ( $settings->input_textarea_height ) { ?>
	height: <?php echo $settings->input_textarea_height; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .ff-el-form-control::-webkit-input-placeholder {
	<?php if ( $settings->input_placeholder_color && 'block' == $settings->input_placeholder_display ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->input_placeholder_color ); ?>;
	<?php } else { ?>
	color: transparent;
	opacity: 0;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .ff-el-form-control:-moz-placeholder {
	<?php if ( $settings->input_placeholder_color && 'block' == $settings->input_placeholder_display ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->input_placeholder_color ); ?>;
	<?php } else { ?>
	color: transparent;
	opacity: 0;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .ff-el-form-control::-moz-placeholder {
	<?php if ( $settings->input_placeholder_color && 'block' == $settings->input_placeholder_display ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->input_placeholder_color ); ?>;
	<?php } else { ?>
	color: transparent;
	opacity: 0;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .ff-el-form-control:-ms-input-placeholder {
	<?php if ( $settings->input_placeholder_color && 'block' == $settings->input_placeholder_display ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->input_placeholder_color ); ?>;
	<?php } else { ?>
	color: transparent;
	opacity: 0;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .ff-el-form-control:focus {
	border-color: <?php echo $settings->input_field_focus_color ? BBFS_Helpers::get_color_value( $settings->input_field_focus_color ) : 'transparent'; ?>;
}

<?php FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_alignment',
		'selector'     => ".fl-node-$id .bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper",
		'prop'         => 'text-align',
	)
);
?>

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button {
	<?php if ( $settings->button_text_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->button_text_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->button_bg_color ) && ! empty( $settings->button_bg_color ) ) { ?>
	background-color: <?php echo BBFS_Helpers::get_color_value( $settings->button_bg_color ); ?>;
	<?php } ?>
	<?php if ( 'true' == $settings->button_width ) { ?> 
	width: 100%; 
	<?php } ?>
}

<?php
	// Button - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'button_border',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button, .fl-node-$id .bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button:hover",
	) );

	// Button Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'button_typography',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button",
	) );

	// Button - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'button_padding',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'button_padding_top',
			'padding-right' 	=> 'button_padding_right',
			'padding-bottom' 	=> 'button_padding_bottom',
			'padding-left' 		=> 'button_padding_left',
		),
	) );
?>

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform .ff_submit_btn_wrapper button:hover {
	<?php if ( $settings->button_text_color_hover ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->button_text_color_hover ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->button_background_color_hover ) && ! empty( $settings->button_background_color_hover ) ) { ?>
	background-color: <?php echo BBFS_Helpers::get_color_value( $settings->button_background_color_hover ); ?>;
	<?php } ?>
}

<?php if ( 'yes' === $settings->radio_cb_style ) : // Radio & Checkbox ?>
	/* Radio & Checkbox */
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=radio],
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=radio]:focus,
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=checkbox],
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=checkbox]:focus {
		-webkit-appearance: none;
		-moz-appearance: none;
		outline: none;
		<?php if ( $settings->radio_cb_size >= 0 ) : ?>
			width: <?php echo $settings->radio_cb_size; ?>px !important;
			height: <?php echo $settings->radio_cb_size; ?>px !important;
		<?php endif; ?>
		<?php if ( ! empty( $settings->radio_cb_color ) ) : ?>
			background: <?php echo BBFS_Helpers::get_color_value( $settings->radio_cb_color ); ?>;
			background-color: <?php echo BBFS_Helpers::get_color_value( $settings->radio_cb_color ); ?>;
		<?php endif; ?>
		<?php if ( $settings->radio_cb_border_width >= 0 && ! empty( $settings->radio_cb_border_color ) ) : ?>
			border: <?php echo $settings->radio_cb_border_width; ?>px solid <?php echo BBFS_Helpers::get_color_value( $settings->radio_cb_border_color ); ?>;
		<?php endif; ?>
		padding: 2px;
	}
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=radio],
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=radio]:focus,
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=radio]:before,
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=radio]:focus:before {
		<?php if ( $settings->radio_cb_radius >= 0 ) : ?>
			border-radius: <?php echo $settings->radio_cb_radius; ?>px;
		<?php endif; ?>
	}
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=checkbox],
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=checkbox]:focus,
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=checkbox]:before,
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=checkbox]:focus:before {
		<?php if ( $settings->radio_cb_radius >= 0 ) : ?>
			border-radius: <?php echo $settings->radio_cb_checkbox_radius; ?>px;
		<?php endif; ?>
	}

	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=radio]:before,
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=radio]:focus:before,
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=checkbox]:before,
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=checkbox]:focus:before {
		content: "";
		width: 100%;
		height: 100%;
		padding: 0;
		margin: 0;
		display: block;
	}

	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=radio]:checked:before,
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=radio]:focus:checked:before,
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=checkbox]:checked:before,
	.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .fluentform input[type=checkbox]:focus:checked:before {
		<?php if ( ! empty( $settings->radio_cb_checked_color ) ) : ?>
			background: <?php echo BBFS_Helpers::get_color_value( $settings->radio_cb_checked_color ); ?>;
			background-color: <?php echo BBFS_Helpers::get_color_value( $settings->radio_cb_checked_color ); ?>;
		<?php endif; ?>
	}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .ff-el-section-break {
	background-color: <?php echo ( $settings->section_field_bg_color ) ? BBFS_Helpers::get_color_value( $settings->section_field_bg_color ) : 'transparent'; ?>;
	<?php if ( $settings->section_description_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->section_description_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .ff-el-section-break .ff-el-section-title {
	<?php if ( $settings->section_title_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->section_title_color ); ?>;
	<?php } ?>
}

<?php
	// Section - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'section_field_border',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .ff-el-section-break",
	) );

	// Section Title Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'section_title_typography',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .ff-el-section-break .ff-el-section-title",
	) );
	// Section Description Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'section_description_typography',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .ff-el-section-break",
	) );

	// Section - Margin
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'section_field_margin',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .ff-el-section-break",
		'unit'			=> 'px',
		'props'			=> array(
			'margin-top' 		=> 'section_field_margin_top',
			'margin-right' 		=> 'section_field_margin_right',
			'margin-bottom' 	=> 'section_field_margin_bottom',
			'margin-left' 		=> 'section_field_margin_left',
		),
	) );

	// Section - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'section_field_padding',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .ff-el-section-break",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'section_field_padding_top',
			'padding-right' 	=> 'section_field_padding_right',
			'padding-bottom' 	=> 'section_field_padding_bottom',
			'padding-left' 		=> 'section_field_padding_left',
		),
	) );
?>


.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .ff-el-is-error .error {
	<?php if ( $settings->error_message ) { ?>
	display: <?php echo $settings->error_message; ?>;
	<?php } ?>
	<?php if ( $settings->error_message_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->error_message_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .ff-el-is-error .ff-el-form-control {
	<?php if ( $settings->error_input_field_border_color || $settings->error_input_field_border_width ) { ?>
	border-style: solid;
	border-color: <?php echo BBFS_Helpers::get_color_value( $settings->error_input_field_border_color ); ?>;
	border-width: <?php echo $settings->error_input_field_border_width; ?>px;
	<?php } ?>
}

<?php
	// Error Message Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'error_typography',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .ff-el-is-error .error",
	) );
?>

.fl-node-<?php echo $id; ?> .bbfs-fluent-form-content .ff-message-success {
	<?php if ( $settings->success_message_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->success_message_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->success_message_bg_color ) && ! empty( $settings->success_message_bg_color ) ) { ?>
	background-color: <?php echo BBFS_Helpers::get_color_value( $settings->success_message_bg_color ); ?>;
	<?php } ?>
}

<?php
	// Success Message - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'success_message_border',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .ff-message-success",
	) );

	// Success Message Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'success_message_typography',
		'selector' 		=> ".fl-node-$id .bbfs-fluent-form-content .ff-message-success",
	) );
?>

<?php
// Address Block - Padding
FLBuilderCSS::responsive_rule( array(
	'settings'     => $settings,
	'setting_name' => 'address_block_padding',
	'selector'     => ".fl-node-$id .bbfs-fluent-form-content .ff-el-form-group[data-type=\"address\"]",
	'prop'         => 'padding',
	'unit'         => 'px',
) );

// Address Block - Margin Bottom
FLBuilderCSS::responsive_rule( array(
	'settings'     => $settings,
	'setting_name' => 'address_block_margin_bottom',
	'selector'     => ".fl-node-$id .bbfs-fluent-form-content .ff-el-form-group[data-type=\"address\"]",
	'prop'         => 'margin-bottom',
	'unit'         => 'px',
) );
?>