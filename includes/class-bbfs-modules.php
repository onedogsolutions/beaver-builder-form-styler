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
		 * Module class names keyed by their directory / file slug.
		 *
		 * @var array
		 */
		protected static $modules = array(
			'bbfs-gravity-form' => 'BBFS_Gravity_Form_Module',
			'bbfs-fluent-form'  => 'BBFS_Fluent_Form_Module',
		);

		/**
		 * Register both form-styler modules.
		 *
		 * @return void
		 */
		public static function register() {
			if ( ! class_exists( 'FLBuilder' ) ) {
				return;
			}

			foreach ( self::$modules as $slug => $class ) {
				$file = BBFS_DIR . 'modules/' . $slug . '/' . $slug . '.php';

				if ( ! file_exists( $file ) ) {
					self::log( sprintf( 'Module file is missing: %s', $file ) );
					continue;
				}

				require_once $file;

				if ( ! class_exists( $class ) ) {
					self::log( sprintf( 'Module file %s did not define %s.', $file, $class ) );
				}
			}
		}

		/**
		 * Log a registration problem without interrupting the page.
		 *
		 * @param string $message Message to log.
		 * @return void
		 */
		protected static function log( $message ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				error_log( 'Beaver Builder Form Styler: ' . $message ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			}
		}

		/**
		 * Build a map of form IDs to whether that form contains an address field.
		 *
		 * Computed once per builder request and handed to the editor as JSON so
		 * the module settings helpers can show or hide the Address Block tab
		 * without making a request of their own.
		 *
		 * @return array Provider slug => array( form id => bool ).
		 */
		public static function get_address_field_map() {
			return array(
				'gravity' => self::gravity_address_field_map(),
				'fluent'  => self::fluent_address_field_map(),
			);
		}

		/**
		 * Address-field map for every Gravity Form.
		 *
		 * @return array
		 */
		protected static function gravity_address_field_map() {
			$map = array();

			if ( ! class_exists( 'GFAPI' ) ) {
				return $map;
			}

			$forms = GFAPI::get_forms();

			if ( empty( $forms ) || is_wp_error( $forms ) ) {
				return $map;
			}

			foreach ( $forms as $form ) {
				if ( ! isset( $form['id'] ) ) {
					continue;
				}

				$map[ (string) $form['id'] ] = self::form_fields_have_address( isset( $form['fields'] ) ? $form['fields'] : array() );
			}

			return $map;
		}

		/**
		 * Address-field map for every Fluent Form.
		 *
		 * @return array
		 */
		protected static function fluent_address_field_map() {
			$map = array();

			if ( ! function_exists( 'wpFluentForm' ) ) {
				return $map;
			}

			global $wpdb;

			$forms = $wpdb->get_results( "SELECT id, form_fields FROM {$wpdb->prefix}fluentform_forms" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

			if ( empty( $forms ) ) {
				return $map;
			}

			foreach ( $forms as $form ) {
				$fields = empty( $form->form_fields ) ? array() : json_decode( $form->form_fields, true );

				$map[ (string) $form->id ] = self::array_contains_address_field( $fields );
			}

			return $map;
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

			return self::form_fields_have_address( $form['fields'] );
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

			$form = $wpdb->get_row( $wpdb->prepare( "SELECT form_fields FROM {$wpdb->prefix}fluentform_forms WHERE id = %d", $form_id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

			if ( empty( $form ) || empty( $form->form_fields ) ) {
				return false;
			}

			return self::array_contains_address_field( json_decode( $form->form_fields, true ) );
		}

		/**
		 * Check a Gravity Forms field collection for an address field.
		 *
		 * @param array $fields Gravity Forms field objects.
		 * @return bool
		 */
		protected static function form_fields_have_address( $fields ) {
			if ( ! is_array( $fields ) ) {
				return false;
			}

			foreach ( $fields as $field ) {
				if ( isset( $field->type ) && 'address' === $field->type ) {
					return true;
				}
				if ( is_array( $field ) && isset( $field['type'] ) && 'address' === $field['type'] ) {
					return true;
				}
			}

			return false;
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

			foreach ( $fields as $value ) {
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
