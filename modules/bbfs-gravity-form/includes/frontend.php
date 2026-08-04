<?php
$enable_ajax = 'yes' === $settings->form_ajax ? 'true' : 'false';
$shortcode   = '[gravityform';
$shortcode   .= ' id="' . absint( $settings->select_form_field ) . '"';
$shortcode   .= ' title="' . $settings->title_field . '"';
$shortcode   .= ' description="' . $settings->description_field . '"';
$shortcode   .= ' ajax="' . $enable_ajax . '"';
if ( '' !== $settings->form_tab_index ) {
	$shortcode .= ' tabindex="' . intval( $settings->form_tab_index ) . '"';
}
if ( apply_filters( 'pp_gravity_forms_use_gravity_theme', true, $settings ) ) {
	$shortcode .= ' theme="gravity"';
}
$shortcode .= ']';
?>
<div class="bbfs-gravity-form-content">
	<div class="bbfs-gravity-form-inner">
	<?php if ( 'yes' === $settings->form_custom_title_desc ) { ?>
		<h3 class="form-title"><?php echo $settings->custom_title; ?></h3>
		<p class="form-description"><?php echo $settings->custom_description; ?></p>
	<?php } ?>
	<?php
	if ( ! empty( $settings->select_form_field ) ) {
		// if ( is_callable( 'GFCommon::gform_do_shortcode' ) && class_exists( 'GFFormDisplay' ) && ! wp_doing_ajax() ) {
		// 	echo GFCommon::gform_do_shortcode( $shortcode );
		// } else {
		// 	echo do_shortcode( $shortcode );
		// }
		echo do_shortcode( $shortcode );
	}
	?>
	</div>
</div>
