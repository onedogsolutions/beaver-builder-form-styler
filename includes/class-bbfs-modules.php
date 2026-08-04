<?php
/**
 * BBFS Modules
 *
 * Registers the Gravity Forms and Fluent Forms modules and provides
 * shared helpers for address-field detection.
 *
 * @package BB_Form_Styler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BBFS_Modules' ) ) {

	/**
	 * Class BBFS_Modules
	 */
	class BBFS_Modules {

		/**
		 * Register both form-styler modules.
		 *
		 * @return void
		 */
		public static function register() {
			if ( ! class_exists( 'FLBuilder' ) ) {
				return;
			}

			// Gravity Form module.
			if ( file_exists( BBFS_DIR . 'modules/bbfs-gravity-form/bbfs-gravity-form.php' ) ) {
				require_once BBFS_DIR . 'modules/bbfs-gravity-form/bbfs-gravity-form.php';
			}
			
			// Fluent Form module.
			if ( file_exists( BBFS_DIR . 'modules/bbfs-fluent-form/bbfs-fluent-form.php' ) ) {
				require_once BBFS_DIR . 'modules/bbfs-fluent-form/bbfs-fluent-form.php';
			}
		}

		/**
		 * Check whether a Gravity Form contains an address field.
		 *
		 * @param int $form_id Form ID.
		 * @return bool
		 */
		public static function gravity_form_has_address( $form_id ) {
			if ( empty( $form_id ) || ! class_exists( 'GFAPI' ) ) {
				return false;
			}

			$form = GFAPI::get_form( $form_id );

			if ( empty( $form ) || is_wp_error( $form ) || empty( $form['fields'] ) ) {
				return false;
			}

			foreach ( $form['fields'] as $field ) {
				if ( isset( $field->type ) && 'address' === $field->type ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Check whether a Fluent Form contains an address field.
		 *
		 * @param int $form_id Form ID.
		 * @return bool
		 */
		public static function fluent_form_has_address( $form_id ) {
			if ( empty( $form_id ) || ! function_exists( 'wpFluentForm' ) ) {
				return false;
			}

			global $wpdb;

			$form = $wpdb->get_row( $wpdb->prepare( "SELECT form_fields FROM {$wpdb->prefix}fluentform_forms WHERE id = %d", $form_id ) );

			if ( empty( $form ) || empty( $form->form_fields ) ) {
				return false;
			}

			$fields = json_decode( $form->form_fields, true );

			return self::array_contains_address_field( $fields );
		}

		/**
		 * Recursively search an array of form fields for an address type.
		 *
		 * @param array $fields Form fields array.
		 * @return bool
		 */
		protected static function array_contains_address_field( $fields ) {
			if ( ! is_array( $fields ) ) {
				return false;
			}

			foreach ( $fields as $key => $value ) {
				if ( is_array( $value ) ) {
					if ( isset( $value['type'] ) && 'address' === $value['type'] ) {
						return true;
					}
					if ( self::array_contains_address_field( $value ) ) {
						return true;
					}
				}
			}

			return false;
		}
	}
}
