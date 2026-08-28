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
		 * Slugs that reached FLBuilderModel::$modules.
		 *
		 * @var array
		 */
		protected static $registered = array();

		/**
		 * Slug => reason for every module that failed to register.
		 *
		 * @var array
		 */
		protected static $failures = array();

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
					self::fail( $slug, sprintf( 'the module file is missing (%s)', $file ) );
					continue;
				}

				require_once $file;

				if ( ! class_exists( $class ) ) {
					self::fail( $slug, sprintf( 'the module file did not define %s', $class ) );
					continue;
				}

				// Beaver Builder drops a module whose slug is already taken and
				// only writes to the error log, so confirm ours actually landed.
				if ( ! self::is_registered_with_builder( $slug, $class ) ) {
					self::fail(
						$slug,
						'Beaver Builder rejected the registration. A module with this filename is already registered by another plugin or theme.'
					);
					continue;
				}

				self::$registered[] = $slug;
			}
		}

		/**
		 * Whether our module owns its slug in Beaver Builder's registry.
		 *
		 * Checking that the slug is merely present is not enough: when another
		 * plugin has already claimed it, Beaver Builder keeps that plugin's
		 * instance and discards ours. Only an instance of our own class proves
		 * the registration succeeded.
		 *
		 * @param string $slug  Module slug.
		 * @param string $class Module class name.
		 * @return bool
		 */
		protected static function is_registered_with_builder( $slug, $class ) {
			if ( ! class_exists( 'FLBuilderModel' ) || ! isset( FLBuilderModel::$modules ) ) {
				// Nothing to check against; assume the registration call worked.
				return true;
			}

			if ( ! isset( FLBuilderModel::$modules[ $slug ] ) ) {
				return false;
			}

			return FLBuilderModel::$modules[ $slug ] instanceof $class;
		}

		/**
		 * Keep our modules in Beaver Builder's enabled-modules list.
		 *
		 * FLBuilderModel::get_enabled_modules() returns the saved
		 * _fl_builder_enabled_modules option verbatim whenever that option
		 * exists and does not contain 'all'. Saving Settings -> Beaver Builder
		 * -> Modules writes an explicit slug list, and any module that was not
		 * registered at that moment is simply absent from it. Because
		 * get_categorized_modules() skips every module whose slug is missing
		 * from that list, our modules silently vanish from the content panel
		 * while remaining perfectly registered.
		 *
		 * Re-adding the slugs here makes the panel authoritative on what this
		 * plugin provides. Return false from bbfs_force_enable_modules to
		 * respect the saved list instead.
		 *
		 * @param array $enabled Enabled module slugs.
		 * @return array
		 */
		public static function force_enabled_modules( $enabled ) {
			if ( ! is_array( $enabled ) ) {
				return $enabled;
			}

			/**
			 * Filter whether the form styler modules are force-enabled.
			 *
			 * @param bool $force Whether to keep the modules in the enabled list.
			 */
			if ( ! apply_filters( 'bbfs_force_enable_modules', true ) ) {
				return $enabled;
			}

			foreach ( self::$registered as $slug ) {
				if ( ! in_array( $slug, $enabled, true ) ) {
					$enabled[] = $slug;
				}
			}

			return $enabled;
		}

		/**
		 * Pre-declare the module category so it renders in a stable position.
		 *
		 * @param array $categories Custom category names.
		 * @return array
		 */
		public static function register_category( $categories ) {
			if ( ! is_array( $categories ) || empty( self::$registered ) ) {
				return $categories;
			}

			$name = BBFS_Helpers::get_modules_cat( 'form_style' );

			if ( ! in_array( $name, $categories, true ) ) {
				$categories[] = $name;
			}

			return $categories;
		}

		/**
		 * Registration failures, keyed by slug.
		 *
		 * @return array
		 */
		public static function get_failures() {
			return self::$failures;
		}

		/**
		 * Record a registration failure and log it.
		 *
		 * @param string $slug   Module slug.
		 * @param string $reason Why registration failed.
		 * @return void
		 */
		protected static function fail( $slug, $reason ) {
			self::$failures[ $slug ] = $reason;
			self::log( sprintf( 'Module %s was not registered: %s', $slug, $reason ) );
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
