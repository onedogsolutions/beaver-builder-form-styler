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
			// Beaver Builder loads core modules on init priority 2, so 11 is
			// comfortably after it without waiting for the editor to boot.
			add_action( 'init', array( __CLASS__, 'register_modules' ), 11 );

			// Keep the modules visible in the content panel and give the
			// category a stable position. Both filters are read every time the
			// panel is built, so they must be added before that happens.
			add_filter( 'fl_builder_enabled_modules', array( __CLASS__, 'filter_enabled_modules' ) );
			add_filter( 'fl_builder_module_categories', array( __CLASS__, 'filter_module_categories' ) );

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
		 * Keep the form styler modules in Beaver Builder's enabled list.
		 *
		 * @param array $enabled Enabled module slugs.
		 * @return array
		 */
		public static function filter_enabled_modules( $enabled ) {
			if ( ! class_exists( 'BBFS_Modules' ) ) {
				return $enabled;
			}

			return BBFS_Modules::force_enabled_modules( $enabled );
		}

		/**
		 * Declare the form styler module category.
		 *
		 * @param array $categories Custom category names.
		 * @return array
		 */
		public static function filter_module_categories( $categories ) {
			if ( ! class_exists( 'BBFS_Modules' ) ) {
				return $categories;
			}

			return BBFS_Modules::register_category( $categories );
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
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			if ( ! class_exists( 'FLBuilder' ) ) {
				printf(
					'<div class="notice notice-warning"><p>%s</p></div>',
					esc_html__( 'Beaver Builder Form Styler needs Beaver Builder to be active. Its modules will not appear in the builder until then.', 'bb-form-styler' )
				);
				return;
			}

			self::registration_failure_notice();
		}

		/**
		 * Report modules that Beaver Builder did not accept.
		 *
		 * Beaver Builder refuses a module whose slug is already taken and only
		 * writes to the error log, which makes an empty content panel very hard
		 * to explain. Surfacing it here names the failing module instead.
		 *
		 * @return void
		 */
		protected static function registration_failure_notice() {
			if ( ! class_exists( 'BBFS_Modules' ) ) {
				return;
			}

			$failures = BBFS_Modules::get_failures();

			if ( empty( $failures ) ) {
				return;
			}

			$items = '';

			foreach ( $failures as $slug => $reason ) {
				$items .= sprintf( '<li><code>%s</code> &mdash; %s</li>', esc_html( $slug ), esc_html( $reason ) );
			}

			printf(
				'<div class="notice notice-error"><p>%s</p><ul>%s</ul></div>',
				esc_html__( 'Beaver Builder Form Styler could not register the following modules, so they will not appear in the builder:', 'bb-form-styler' ),
				$items // phpcs:ignore WordPress.Security.EscapeOutput
			);
		}
	}
}
