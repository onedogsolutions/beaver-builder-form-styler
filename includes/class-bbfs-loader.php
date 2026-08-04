<?php
/**
 * BBFS Loader
 *
 * Bootstraps the plugin and registers Beaver Builder modules.
 *
 * @package BB_Form_Styler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BBFS_Loader' ) ) {

	/**
	 * Class BBFS_Loader
	 */
	class BBFS_Loader {

		/**
		 * Initialize the plugin.
		 *
		 * @return void
		 */
		public static function init() {
			// Load helpers.
			require_once BBFS_DIR . 'includes/class-bbfs-helpers.php';

			// Register modules when Beaver Builder is available.
			add_action( 'init', array( __CLASS__, 'register_modules' ), 11 );

			// AJAX endpoint for address-field detection (editor only, requires login).
			add_action( 'wp_ajax_bbfs_check_form_address_field', array( __CLASS__, 'ajax_check_form_address_field' ) );

			// Enqueue editor nonce for JS helpers.
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts' ) );
		}

		/**
		 * Enqueue a small JS object with the AJAX nonce for use by module settings.js.
		 *
		 * @return void
		 */
		public static function admin_enqueue_scripts() {
			if ( ! is_admin() ) {
				return;
			}

			wp_add_inline_script( 'fl-builder', 'var bbfs = ' . wp_json_encode( array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'bbfs_nonce' ),
			) ) . ';', 'before' );
		}

		/**
		 * Register the custom Beaver Builder modules.
		 *
		 * @return void
		 */
		public static function register_modules() {
			if ( ! class_exists( 'FLBuilder' ) ) {
				return;
			}

			require_once BBFS_DIR . 'includes/class-bbfs-modules.php';

			BBFS_Modules::register();
		}

		/**
		 * AJAX handler to check if a selected form contains an address field.
		 *
		 * @return void
		 */
		public static function ajax_check_form_address_field() {
			check_ajax_referer( 'bbfs_nonce', 'nonce' );

			$form_id   = isset( $_POST['form_id'] ) ? sanitize_text_field( wp_unslash( $_POST['form_id'] ) ) : '';
			$provider  = isset( $_POST['provider'] ) ? sanitize_text_field( wp_unslash( $_POST['provider'] ) ) : '';
			$has_address = false;

			if ( 'gravity' === $provider && class_exists( 'GFForms' ) ) {
				$has_address = BBFS_Modules::gravity_form_has_address( absint( $form_id ) );
			} elseif ( 'fluent' === $provider && function_exists( 'wpFluentForm' ) ) {
				$has_address = BBFS_Modules::fluent_form_has_address( absint( $form_id ) );
			}

			wp_send_json_success( array( 'has_address' => $has_address ) );
		}
	}
}
