<div class="bbfs-fluent-form-content">
	<?php if ( $settings->custom_title ) { ?>
		<<?php echo esc_attr( $settings->title_tag ); ?> class="bbfs-form-title"><?php echo $settings->custom_title; ?></<?php echo esc_attr( $settings->title_tag ); ?>>
	<?php } ?>
	<?php if ( $settings->custom_description ) { ?>
		<p class="bbfs-form-description">
			<?php echo $settings->custom_description; ?>
		</p>
	<?php } ?>
    <?php
    if ( $settings->select_form_field ) {
        echo do_shortcode( '[fluentform id=' . $settings->select_form_field . ']' );
    }
    ?>
</div>
