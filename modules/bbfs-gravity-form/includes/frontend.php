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
if ( apply_filters( 'bbfs_gravity_form_use_gravity_theme', true, $settings ) ) {
	$shortcode .= ' theme="gravity"';
}
$shortcode .= ']';
?>
<div class="bbfs-gravity-form-content">
	<div class="bbfs-gravity-form-inner">
	<?php if ( 'yes' === $settings->form_custom_title_desc ) { ?>
		<h3 class="bbfs-form-title"><?php echo wp_kses_post( $settings->custom_title ); ?></h3>
		<p class="bbfs-form-description"><?php echo wp_kses_post( $settings->custom_description ); ?></p>
	<?php } ?>
	<?php
	if ( ! empty( $settings->select_form_field ) ) {
		echo do_shortcode( $shortcode );
	}
	?>
	</div>
</div>
