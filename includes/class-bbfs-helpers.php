<?php
/**
 * BBFS Helpers
 *
 * Shared utilities used by the Gravity Forms and Fluent Forms modules:
 * color normalization, rgba conversion, tag sanitization and the module
 * category name.
 *
 * @package BB_Form_Styler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BBFS_Helpers' ) ) {

	/**
	 * Class BBFS_Helpers
	 */
	class BBFS_Helpers {

		/**
		 * Resolve a Beaver Builder color value to a usable CSS color.
		 *
		 * @param string $color Raw color value.
		 * @return string
		 */
		public static function get_color_value( $color ) {
			if ( is_callable( 'FLBuilderColor::hex_or_rgb' ) ) {
				return FLBuilderColor::hex_or_rgb( $color );
			}

			if ( ! empty( $color ) && ! stristr( $color, 'rgb' ) && ! stristr( $color, 'var' ) ) {
				return '#' . $color;
			}

			return $color;
		}

		/**
		 * Convert a hex color to an rgba() string.
		 *
		 * @param string $hex     Hex color.
		 * @param float  $opacity Opacity.
		 * @return string
		 */
		public static function hex_to_rgba( $hex, $opacity = 1 ) {
			if ( stristr( $hex, 'rgb' ) || stristr( $hex, 'var' ) ) {
				return $hex;
			}

			$hex = str_replace( '#', '', $hex );

			if ( strlen( $hex ) === 3 ) {
				$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
				$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
				$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
			} else {
				$r = hexdec( substr( $hex, 0, 2 ) );
				$g = hexdec( substr( $hex, 2, 2 ) );
				$b = hexdec( substr( $hex, 4, 2 ) );
			}

			$opacity = ( $opacity > 1 ) ? ( $opacity / 100 ) : $opacity;

			return 'rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $opacity . ')';
		}

		/**
		 * Whether the current request is a Beaver Builder editor request.
		 *
		 * Beaver Builder's editor AJAX posts back to the builder page URL itself
		 * rather than to admin-ajax.php, so every editor request - the initial
		 * page load and each subsequent AJAX call - carries the fl_builder query
		 * arg. That makes this a reliable gate for editor-only work such as
		 * querying the form tables.
		 *
		 * @return bool
		 */
		public static function is_builder_request() {
			return isset( $_GET['fl_builder'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		/**
		 * Restrict a value to a safe HTML tag name.
		 *
		 * Used as a settings sanitize callback for tag-name fields so a saved
		 * value can never be interpolated into markup as arbitrary content.
		 *
		 * @param string $tag      Raw tag name.
		 * @param string $fallback Tag to use when $tag is not allowed.
		 * @return string
		 */
		public static function esc_tags( $tag, $fallback = 'h3' ) {
			$allowed = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'p', 'span' );
			$tag     = strtolower( trim( (string) $tag ) );

			return in_array( $tag, $allowed, true ) ? $tag : $fallback;
		}

		/**
		 * Get the Beaver Builder module category name.
		 *
		 * @param string $cat Category slug.
		 * @return string
		 */
		public static function get_modules_cat( $cat ) {
			$categories = array(
				'form_style' => __( 'Form Styler Modules', 'bb-form-styler' ),
			);

			$name = isset( $categories[ $cat ] ) ? $categories[ $cat ] : $cat;

			/**
			 * Filter the module category the form styler modules are listed under.
			 *
			 * @param string $name Category name shown in the builder content panel.
			 * @param string $cat  Category slug.
			 */
			return apply_filters( 'bbfs_modules_category', $name, $cat );
		}
	}
}
