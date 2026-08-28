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
		 * Inline data awaiting a footer print.
		 *
		 * @var string
		 */
		protected static $inline_data = '';

		/**
		 * Initialize the plugin.
		 *
		 * @return void
		 */
		public static function init() {
			require_once BBFS_DIR . 'includes/class-bbfs-helpers.php';

			// Register modules once Beaver Builder has loaded its own.
			add_action( 'init', array( __CLASS__, 'register_modules' ), 11 );

			// Hand the editor its form data. Both hooks fire late so the
			// builder script handle is already registered.
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_editor_data' ), 999 );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_editor_data' ), 999 );

			// Warn if the plugin is active without Beaver Builder.
			add_action( 'admin_notices', array( __CLASS__, 'builder_missing_notice' ) );
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
		 * Expose the address-field map to the builder as window.BBFSData.
		 *
		 * The module settings helpers read this to decide whether the Address
		 * Block tab applies to the selected form. Computing it here means the
		 * editor never has to make a request of its own.
		 *
		 * @return void
		 */
		public static function enqueue_editor_data() {
			if ( ! BBFS_Helpers::is_builder_request() || ! class_exists( 'FLBuilder' ) ) {
				return;
			}

			require_once BBFS_DIR . 'includes/class-bbfs-modules.php';

			$data   = array( 'addressFields' => BBFS_Modules::get_address_field_map() );
			$script = 'window.BBFSData = ' . wp_json_encode( $data ) . ';';

			if ( ! wp_add_inline_script( 'fl-builder', $script, 'before' ) ) {
				self::$inline_data = $script;
				add_action( 'wp_footer', array( __CLASS__, 'print_editor_data' ), 5 );
				add_action( 'admin_footer', array( __CLASS__, 'print_editor_data' ), 5 );
			}
		}

		/**
		 * Fallback printer for when the builder script handle is unavailable.
		 *
		 * @return void
		 */
		public static function print_editor_data() {
			if ( '' === self::$inline_data ) {
				return;
			}

			if ( function_exists( 'wp_print_inline_script_tag' ) ) {
				wp_print_inline_script_tag( self::$inline_data );
			} else {
				echo '<script>' . self::$inline_data . '</script>'; // phpcs:ignore WordPress.Security.EscapeOutput
			}
			self::$inline_data = '';
		}

		/**
		 * Show an admin notice when Beaver Builder is not available.
		 *
		 * @return void
		 */
		public static function builder_missing_notice() {
			if ( class_exists( 'FLBuilder' ) || ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			printf(
				'<div class="notice notice-warning"><p>%s</p></div>',
				esc_html__( 'Beaver Builder Form Styler needs Beaver Builder to be active. Its modules will not appear in the builder until then.', 'bb-form-styler' )
			);
		}
	}
}
