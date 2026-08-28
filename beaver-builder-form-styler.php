<?php
/**
 * Plugin Name: Beaver Builder Form Styler
 * Description: Gravity Forms and Fluent Forms styling modules for Beaver Builder.
 * Version: 1.2.1
 * Author: Ryan Waterbury, One Dog Solutions
 * Text Domain: bb-form-styler
 * Domain Path: /languages
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants.
define( 'BBFS_VERSION', '1.2.1' );
define( 'BBFS_FILE', __FILE__ );
define( 'BBFS_DIR', plugin_dir_path( __FILE__ ) );
define( 'BBFS_URL', plugin_dir_url( __FILE__ ) );

// Load the plugin.
require_once BBFS_DIR . 'includes/class-bbfs-loader.php';

// Bootstrap.
add_action( 'plugins_loaded', array( 'BBFS_Loader', 'init' ) );
