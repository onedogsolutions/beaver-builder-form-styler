<?php
// Form Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'form_border_group',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content",
	)
);
// Button Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_border_group',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gform-button, .fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gform_footer .gform_button,
							.fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gform_page_footer .button",
	)
);
// Form Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'form_padding',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'form_padding_top',
			'padding-right'  => 'form_padding_right',
			'padding-bottom' => 'form_padding_bottom',
			'padding-left'   => 'form_padding_left',
		),
	)
);
// Form Title Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'title_typography',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gform_title,
							.fl-node-$id .bbfs-form-title",
	)
);
// Form Description Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'description_typography',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper span.gform_description,
							.fl-node-$id .bbfs-form-description",
	)
);
// Form Section Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'section_typography',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper h2.gsection_title, .fl-node-$id .bbfs-gravity-form-content .gform_wrapper h3.gsection_title",
	)
);
// Form Button Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_typography',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gform-button,
							.fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gform_footer .gform_button, 
							.fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gform_page_footer .button",
	)
);
?>

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper {
	max-width: 100%;
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content {
	background-color: <?php echo $settings->form_bg_color ? BBFS_Helpers::get_color_value( $settings->form_bg_color ) : 'transparent'; ?>;
	<?php if ( $settings->form_bg_image && 'image' === $settings->form_bg_type ) { ?>
	background-image: url('<?php echo $settings->form_bg_image_src; ?>');
	<?php } ?>
	<?php if ( $settings->form_bg_size ) { ?>
	background-size: <?php echo $settings->form_bg_size; ?>;
	<?php } ?>
	<?php if ( $settings->form_bg_repeat ) { ?>
	background-repeat: <?php echo $settings->form_bg_repeat; ?>;
	<?php } ?>
}

<?php if ( $settings->form_bg_image && 'image' === $settings->form_bg_type ) { ?>
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content:before {
	background-color: <?php echo ( $settings->form_bg_overlay ) ? BBFS_Helpers::hex_to_rgba( BBFS_Helpers::get_color_value( $settings->form_bg_overlay ), $settings->form_bg_overlay_opacity / 100 ) : 'transparent'; ?>;
}
<?php } ?>

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper ul li.gfield:not(.gfield--type-address):not(.address) {
	list-style-type: none !important;
	<?php if ( $settings->input_field_margin >= 0 ) { ?>
	margin-bottom: <?php echo $settings->input_field_margin; ?>px;
	<?php } ?>
}

.fl-builder-content .fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_title,
.fl-builder-content .fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .bbfs-form-title {
	<?php if ( $settings->title_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->title_color ); ?>;
	<?php } ?>
	display: <?php echo ( 'false' === $settings->title_field ) ? 'none' : 'block'; ?>;
}

.fl-builder-content .fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .bbfs-form-title {
	display: <?php echo ( 'yes' === $settings->form_custom_title_desc ) ? 'block' : 'none'; ?>;
}

.fl-builder-content .fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_title {
	<?php if ( 'yes' === $settings->form_custom_title_desc ) { ?>
	display: none;
	<?php } ?>
}

.fl-builder-content .fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper span.gform_description,
.fl-builder-content .fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .bbfs-form-description {
	<?php if ( $settings->description_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->description_color ); ?>;
	<?php } ?>
	display: <?php echo ( 'false' === $settings->description_field ) ? 'none' : 'block'; ?>;
}

.fl-builder-content .fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .bbfs-form-description {
	display: <?php echo ( 'yes' === $settings->form_custom_title_desc ) ? 'block' : 'none'; ?>;
}

.fl-builder-content .fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper span.gform_description {
	<?php if ( 'yes' === $settings->form_custom_title_desc ) { ?>
	display: none;
	<?php } ?>
}

.fl-builder-content .fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield .gfield_label {
	<?php if ( $settings->form_label_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->form_label_color ); ?>;
	<?php } ?>
	<?php if ( $settings->display_labels ) { ?>
	display: <?php echo $settings->display_labels; ?>;
	<?php } ?>
}

<?php
// Form label Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'label_typography',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield .gfield_label",
	)
);
?>

.fl-builder-content .fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_required {
	<?php if ( isset( $settings->form_required_text_color ) && ! empty( $settings->form_required_text_color ) ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->form_required_text_color ); ?>;
	<?php } ?>
}

.fl-builder-content .fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield .ginput_complex.ginput_container label {
	<?php if ( 'none' === $settings->display_labels ) { ?>
	display: <?php echo $settings->display_labels; ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_container label,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper table.gfield_list thead th,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper span.ginput_product_price,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper span.ginput_product_price_label,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper span.ginput_quantity_label,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_html {
	<?php if ( $settings->form_label_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->form_label_color ); ?> !important;
	<?php } ?>
	<?php if ( is_array( $settings->label_typography ) && isset( $settings->label_typography['font_family'] ) ) {
		$label_font = array(
			'family' => $settings->label_typography['font_family'],
			'weight' => $settings->label_typography['font_weight']
		);
		if ( 'Default' !== $label_font['family'] ) {
			FLBuilderFonts::font_css( $label_font );
		} elseif ( ! empty( $label_font['weight'] ) ) {
			echo "font-weight: {$label_font['weight']};";
		}
	} ?>
}

<?php
// Radio and Checkbox font size.
FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'radio_checkbox_font_size',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper ul.gfield_radio li label, .fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield_radio label, .fl-node-$id .bbfs-gravity-form-content .gform_wrapper ul.gfield_checkbox li label, .fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield_checkbox label, .fl-node-$id .bbfs-gravity-form-content .gform_wrapper .ginput_container_consent label",
		'prop'         => 'font-size',
		'unit'		   => 'px',
	)
);
?>

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper span.ginput_product_price {
	<?php if ( $settings->product_price_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->product_price_color ); ?> !important;
	<?php } ?>
}

<?php
// Form input description Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'input_desc_typography',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield .gfield_description",
	)
);
?>

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield .gfield_description {
	<?php if ( $settings->input_desc_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->input_desc_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gsection {
	<?php if ( $settings->section_border_width >= 0 ) { ?>
	border-bottom-width: <?php echo $settings->section_border_width; ?>px;
	<?php } ?>
	<?php if ( $settings->section_border_color ) { ?>
	border-bottom-color: <?php echo BBFS_Helpers::get_color_value( $settings->section_border_color ); ?>;
	<?php } ?>
	<?php if ( $settings->section_field_margin >= 0 ) { ?>
		margin-bottom: <?php echo $settings->section_field_margin; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper h2.gsection_title,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper h3.gsection_title {
	<?php if ( $settings->section_text_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->section_text_color ); ?>;
	<?php } ?>
}

<?php
// Form input Typography.
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'input_typography',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
						.fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield select,
						.fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield textarea",
	)
);
?>

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield select,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield textarea {
	<?php if ( $settings->input_field_text_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->input_field_text_color ); ?>;
	<?php } ?>
	background-color: <?php echo $settings->input_field_bg_color ? BBFS_Helpers::get_color_value( $settings->input_field_bg_color ) : ''; ?>;
	<?php echo ( 'true' === $settings->input_field_width ) ? 'width: 100% !important;' : ''; ?>
	outline: none;
}

<?php
// Input Border
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'input_field_border_group',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
							.fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield select,
							.fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield textarea",
	)
);

FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'input_field_padding',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield:not(.gfield--type-address):not(.address) input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
							.fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield:not(.gfield--type-address):not(.address) select,
							.fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield:not(.gfield--type-address):not(.address) textarea",
		'prop'         => 'padding',
		'unit'		   => 'px',
	)
);
?>

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield select {
	<?php if ( 'custom' === $settings->input_field_height ) { ?>
		height: <?php echo $settings->input_field_height_custom; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield:not(.gfield--type-address):not(.address) .ginput_complex input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=image]):not([type=file]),
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield:not(.gfield--type-address):not(.address) .ginput_complex select {
	<?php if ( '' !== $settings->input_field_margin && $settings->input_field_margin >= 0 ) { ?>
	margin-bottom: <?php echo ( $settings->input_field_margin * 30 ) / 100; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield:not(.gfield--type-address):not(.address) .ginput_complex span {
	<?php if ( '' !== $settings->input_field_margin && $settings->input_field_margin >= 0 ) { ?>
	margin-bottom: <?php echo ( $settings->input_field_margin * 40 ) / 100; ?>px;
	<?php } ?>
}

<?php if ( $settings->gf_input_placeholder_color && 'block' === $settings->gf_input_placeholder_display ) { ?>
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input::-webkit-input-placeholder {
	color: <?php echo BBFS_Helpers::get_color_value( $settings->gf_input_placeholder_color ); ?>;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input:-moz-placeholder {
	color: <?php echo BBFS_Helpers::get_color_value( $settings->gf_input_placeholder_color ); ?>;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input::-moz-placeholder {
	color: <?php echo BBFS_Helpers::get_color_value( $settings->gf_input_placeholder_color ); ?>;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input:-ms-input-placeholder {
	color: <?php echo BBFS_Helpers::get_color_value( $settings->gf_input_placeholder_color ); ?>;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield textarea::-webkit-input-placeholder {
	color: <?php echo BBFS_Helpers::get_color_value( $settings->gf_input_placeholder_color ); ?>;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield textarea:-moz-placeholder {
	color: <?php echo BBFS_Helpers::get_color_value( $settings->gf_input_placeholder_color ); ?>;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield textarea::-moz-placeholder {
	color: <?php echo BBFS_Helpers::get_color_value( $settings->gf_input_placeholder_color ); ?>;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield textarea:-ms-input-placeholder {
	color: <?php echo BBFS_Helpers::get_color_value( $settings->gf_input_placeholder_color ); ?>;
}
<?php } ?>

<?php if ( 'none' === $settings->gf_input_placeholder_display ) { ?>
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input::-webkit-input-placeholder {
	color: transparent;
	opacity: 0;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input:-moz-placeholder {
	color: transparent;
	opacity: 0;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input::-moz-placeholder {
	color: transparent;
	opacity: 0;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input:-ms-input-placeholder {
	color: transparent;
	opacity: 0;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield textarea::-webkit-input-placeholder {
	color: transparent;
	opacity: 0;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield textarea:-moz-placeholder {
	color: transparent;
	opacity: 0;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield textarea::-moz-placeholder {
	color: transparent;
	opacity: 0;
}
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield textarea:-ms-input-placeholder {
	color: transparent;
	opacity: 0;
}
<?php } ?>

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']):focus,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield select:focus,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield textarea:focus {
	border-color: <?php echo $settings->input_field_focus_color ? BBFS_Helpers::get_color_value( $settings->input_field_focus_color ) : ''; ?>;
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .top_label input.medium,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .top_label select.medium {
	width: <?php echo ( 'true' === $settings->input_field_width ) ? '100%' : '49%'; ?> !important;
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper textarea.medium {
	width: <?php echo ( 'true' === $settings->input_field_width ) ? '100% !important;' : ';'; ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_complex .ginput_full input[type="text"],
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_complex  input[type="text"] {
	width: <?php echo ( 'true' === $settings->input_field_width ) ? '100%' : '97.5%'; ?> !important;
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_complex .ginput_right {
	margin-left: 0 !important;
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_complex .ginput_right input,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_complex .ginput_right select {
	width: <?php echo ( 'true' === $settings->input_field_width ) ? '100% !important;' : ';'; ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_footer {
	<?php if ( $settings->button_alignment ) { ?>
	text-align: <?php echo $settings->button_alignment; ?>;
	<?php } ?>
	<?php if ( 'left' === $settings->button_alignment ) { ?>
		justify-content: flex-start;
	<?php } ?>
	<?php if ( 'right' === $settings->button_alignment ) { ?>
		justify-content: flex-end;
	<?php } ?>
	<?php if ( 'center' === $settings->button_alignment ) { ?>
		justify-content: center;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform-button,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_footer .gform_button,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper.gf_browser_ie .gform_footer .gform_button,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_page_footer .button,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper.gf_browser_ie .gform_page_footer .button {
	<?php if ( 'true' === $settings->button_width ) { ?>
	width: 100%;
	<?php } else { ?>
	width: auto;
	<?php } ?>
	<?php if ( $settings->button_text_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->button_text_color ); ?>;
	<?php } ?>
	background-color: <?php echo $settings->button_bg_color ? BBFS_Helpers::get_color_value( $settings->button_bg_color ) : ''; ?>;
	<?php if ( $settings->button_padding_top_bottom >= 0 ) { ?>
	padding-top: <?php echo $settings->button_padding_top_bottom; ?>px;
	padding-bottom: <?php echo $settings->button_padding_top_bottom; ?>px;
	<?php } ?>
	<?php if ( $settings->button_padding_left_right >= 0 ) { ?>
	padding-left: <?php echo $settings->button_padding_left_right; ?>px;
	padding-right: <?php echo $settings->button_padding_left_right; ?>px;
	<?php } ?>
	white-space: normal;
}

<?php
FLBuilderCSS::responsive_rule( array(
	'settings' => $settings,
	'setting_name' => 'button_custom_width',
	'prop' => 'width',
	'unit' => 'px',
	'enabled' => 'true' !== $settings->button_width,
	'selector' => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gform-button,
		.fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gform_footer .gform_button,
		.fl-node-$id .bbfs-gravity-form-content .gform_wrapper.gf_browser_ie .gform_footer .gform_button,
		.fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gform_page_footer .button,
		.fl-node-$id .bbfs-gravity-form-content .gform_wrapper.gf_browser_ie .gform_page_footer .button"
) );
?>

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_page_footer .button {
	<?php if ( 'true' === $settings->button_width ) { ?>
		margin-bottom: 5px !important;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform-button:hover,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_footer .gform_button:hover,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_page_footer .button:hover {
	<?php if ( $settings->button_hover_text_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->button_hover_text_color ); ?>;
	<?php } ?>
	background: <?php echo $settings->button_hover_bg_color ? BBFS_Helpers::get_color_value( $settings->button_hover_bg_color ) : ''; ?>;
}

<?php if ( 'yes' === $settings->radio_cb_style ) : // Radio & Checkbox ?>
	/* Radio & Checkbox */
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_radio input[type=radio],
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_radio input[type=radio]:focus,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_checkbox input[type=checkbox],
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_checkbox input[type=checkbox]:focus,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_container_consent input[type=checkbox],
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_container_consent input[type=checkbox]:focus,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input[type="checkbox"]:focus,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input[type="radio"]:focus {
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
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_radio input[type=radio],
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_radio input[type=radio]:focus,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_radio input[type=radio]:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_radio input[type=radio]:focus:before {
		<?php if ( $settings->radio_cb_radius >= 0 ) : ?>
			border-radius: <?php echo $settings->radio_cb_radius; ?>px;
		<?php endif; ?>
	}
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_checkbox input[type=checkbox],
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_checkbox input[type=checkbox]:focus,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_checkbox input[type=checkbox]:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_checkbox input[type=checkbox]:focus:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_container_consent input[type=checkbox],
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_container_consent input[type=checkbox]:focus,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_container_consent input[type=checkbox]:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_container_consent input[type=checkbox]:focus:before {
		<?php if ( $settings->radio_cb_radius >= 0 ) : ?>
			border-radius: <?php echo $settings->radio_cb_checkbox_radius; ?>px;
		<?php endif; ?>
	}
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_radio input[type=radio]:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_radio input[type=radio]:focus:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_checkbox input[type=checkbox]:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_checkbox input[type=checkbox]:focus:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_container_consent input[type=checkbox]:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_container_consent input[type=checkbox]:focus:before {
		content: "";
		width: 100%;
		height: 100%;
		padding: 0;
		margin: 0;
		display: block;
	}
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_radio input[type=radio]:checked:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_radio input[type=radio]:focus:checked:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_checkbox input[type=checkbox]:checked:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_checkbox input[type=checkbox]:focus:checked:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_container_consent input[type=checkbox]:checked:before,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .ginput_container_consent input[type=checkbox]:focus:checked:before {
		<?php if ( ! empty( $settings->radio_cb_checked_color ) ) : ?>
			background: <?php echo BBFS_Helpers::get_color_value( $settings->radio_cb_checked_color ); ?>;
			background-color: <?php echo BBFS_Helpers::get_color_value( $settings->radio_cb_checked_color ); ?>;
		<?php endif; ?>
	}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield input[type=file] {
	background-color: <?php echo $settings->file_bg_color ? BBFS_Helpers::get_color_value( $settings->file_bg_color ) : 'transparent'; ?>;
	<?php if ( $settings->file_text_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->file_text_color ); ?>;<?php } ?>
	<?php if ( $settings->file_border_width >= 0 ) { ?>
	border-width: <?php echo $settings->file_border_width; ?>px;
	<?php } ?>
	<?php if ( $settings->file_border_color ) { ?>
	border-color: <?php echo BBFS_Helpers::get_color_value( $settings->file_border_color ); ?>;
	<?php } ?>
	<?php if ( $settings->file_border_style ) { ?>
	border-style: <?php echo $settings->file_border_style; ?>;
	<?php } ?>
	<?php if ( $settings->file_vertical_padding ) { ?>
	padding-top: <?php echo $settings->file_vertical_padding; ?>px;
	<?php } ?>
	<?php if ( $settings->file_vertical_padding ) { ?>
	padding-bottom: <?php echo $settings->file_vertical_padding; ?>px;
	<?php } ?>
	<?php if ( $settings->file_horizontal_padding ) { ?>
	padding-left: <?php echo $settings->file_horizontal_padding; ?>px;
	<?php } ?>
	<?php if ( $settings->file_horizontal_padding ) { ?>
	padding-right: <?php echo $settings->file_horizontal_padding; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .validation_error,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_validation_errors,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_validation_errors > h2,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper li.gfield.gfield_error,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper li.gfield.gfield_error.gfield_contains_required.gfield_creditcard_warning {
	<?php if ( $settings->validation_error_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->validation_error_color ); ?> !important;
	<?php } ?>
	border-color: <?php echo $settings->validation_error_border_color ? BBFS_Helpers::get_color_value( $settings->validation_error_border_color ) : 'transparent'; ?> !important;
	<?php if ( ! isset( $settings->validation_error_border_color ) || empty( $settings->validation_error_border_color ) ) { ?>
		border: none;
		padding-top: 0;
		padding-bottom: 0;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .validation_error,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_validation_errors,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_validation_errors > h2 {
	<?php if ( $settings->validation_error_font_size ) { ?>
	font-size: <?php echo $settings->validation_error_font_size; ?>px !important;
	<?php } ?>
	<?php if ( $settings->validation_error ) { ?>
	display: <?php echo $settings->validation_error; ?> !important;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield.gfield_error {
	background-color: <?php echo ( $settings->form_error_field_background_color ) ? BBFS_Helpers::get_color_value( $settings->form_error_field_background_color ) : 'transparent'; ?>;
	width: 100%;
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield.gfield_error .gfield_label {
	<?php if ( $settings->form_error_field_label_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->form_error_field_label_color ); ?>;
	<?php } ?>
	margin-left: 0;
}

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_error .validation_message {
	<?php if ( $settings->validation_message ) { ?>
	display: <?php echo $settings->validation_message; ?>;
	<?php } ?>
	<?php if ( $settings->validation_message_color ) { ?>
	color: <?php echo BBFS_Helpers::get_color_value( $settings->validation_message_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->validation_error_border_color ) ) { ?>
	border-color: <?php echo BBFS_Helpers::get_color_value( $settings->validation_error_border_color ); ?>;
	<?php } ?>
}

<?php if ( ! isset( $settings->validation_error_border_color ) || empty( $settings->validation_error_border_color ) ) { ?>
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper li.gfield.gfield_error.gfield_contains_required div.ginput_container,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper li.gfield.gfield_error.gfield_contains_required label.gfield_label {
	margin-top: 8px;
}
<?php } ?>

.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_error input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_error .ginput_container select,
.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gfield_error .ginput_container textarea {
	border-color: <?php echo ( $settings->form_error_input_border_color ) ? BBFS_Helpers::get_color_value( $settings->form_error_input_border_color ) : 'transparent'; ?>;
	<?php if ( $settings->form_error_input_border_width >= 0 ) { ?>
	border-width: <?php echo $settings->form_error_input_border_width; ?>px !important;
	<?php } ?>
}


@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform-button,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_footer .gform_button,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper.gf_browser_ie .gform_footer .gform_button,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_page_footer .button,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper.gf_browser_ie .gform_page_footer .button {
		<?php if ( isset( $settings->button_padding_top_bottom_medium ) && $settings->button_padding_top_bottom_medium >= 0 ) { ?>
		padding-top: <?php echo $settings->button_padding_top_bottom_medium; ?>px;
		padding-bottom: <?php echo $settings->button_padding_top_bottom_medium; ?>px;
		<?php } ?>
		<?php if ( isset( $settings->button_padding_left_right_medium ) && $settings->button_padding_left_right_medium >= 0 ) { ?>
		padding-left: <?php echo $settings->button_padding_left_right_medium; ?>px;
		padding-right: <?php echo $settings->button_padding_left_right_medium; ?>px;
		<?php } ?>
	}
}

@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform-button,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_footer .gform_button,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper.gf_browser_ie .gform_footer .gform_button,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper .gform_page_footer .button,
	.fl-node-<?php echo $id; ?> .bbfs-gravity-form-content .gform_wrapper.gf_browser_ie .gform_page_footer .button {
		<?php if ( isset( $settings->button_padding_top_bottom_responsive ) && $settings->button_padding_top_bottom_responsive >= 0 ) { ?>
		padding-top: <?php echo $settings->button_padding_top_bottom_responsive; ?>px;
		padding-bottom: <?php echo $settings->button_padding_top_bottom_responsive; ?>px;
		<?php } ?>
		<?php if ( isset( $settings->button_padding_left_right_responsive ) && $settings->button_padding_left_right_responsive >= 0 ) { ?>
		padding-left: <?php echo $settings->button_padding_left_right_responsive; ?>px;
		padding-right: <?php echo $settings->button_padding_left_right_responsive; ?>px;
		<?php } ?>
	}
}
<?php
// Success Message Border - Settings
if ( isset( $settings->message_border_group ) && ! empty( $settings->message_border_group ) ) {
	FLBuilderCSS::border_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'message_border_group',
			'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_confirmation_wrapper",
		)
	);
}
// Success Message Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'message_padding',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_confirmation_wrapper",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'message_padding_top',
			'padding-right'  => 'message_padding_right',
			'padding-bottom' => 'message_padding_bottom',
			'padding-left'   => 'message_padding_left',
		),
	)
);

// Success Message Typography
if ( isset( $settings->message_typography ) && ! empty( $settings->message_typography ) ) {
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'message_typography',
			'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_confirmation_wrapper .gform_confirmation_message",
		)
	);
}
?>
<?php if ( isset( $settings->message_bg_color ) && ! empty( $settings->message_bg_color ) ) { ?>
	.fl-node-<?php echo $id; ?> .gform_confirmation_wrapper {
		background-color: <?php echo BBFS_Helpers::get_color_value( $settings->message_bg_color ); ?>;
	}
<?php } ?>
<?php if ( isset( $settings->message_color ) && ! empty( $settings->message_color ) ) { ?>
	.fl-node-<?php echo $id; ?> .gform_confirmation_wrapper .gform_confirmation_message {
		color: <?php echo BBFS_Helpers::get_color_value( $settings->message_color ); ?>;
	}
<?php } ?>

<?php
// Address Block - Padding
FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'address_block_padding',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield.gfield--type-address, .fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield.address",
		'prop'         => 'padding',
		'unit'         => 'px',
	)
);

// Address Block - Margin Bottom
FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'address_block_margin_bottom',
		'selector'     => ".fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield.gfield--type-address, .fl-node-$id .bbfs-gravity-form-content .gform_wrapper .gfield.address",
		'prop'         => 'margin-bottom',
		'unit'         => 'px',
	)
);
?>
