<?php
/**
 * BBFS Helpers
 *
 * Self-contained replacements for PowerPack helpers used by the
 * Gravity Forms and Fluent Forms styling modules.
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
		 * Get the Beaver Builder module group name.
		 *
		 * @return string
		 */
		public static function get_modules_group() {
			return __( 'BB Form Styler', 'bb-form-styler' );
		}

		/**
		 * Get the Beaver Builder module category.
		 *
		 * @param string $cat Category slug.
		 * @return string
		 */
		public static function get_modules_cat( $cat ) {
			$categories = array(
				'form_style' => __( 'Form Styler Modules', 'bb-form-styler' ),
			);

			return isset( $categories[ $cat ] ) ? $categories[ $cat ] : $cat;
		}
	}
}
