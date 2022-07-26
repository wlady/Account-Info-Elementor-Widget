<?php
/**
 * @wordpress-plugin
 * Plugin Name: WC Account Info For Elementor
 * Version:     1.0.0
 * Plugin URI:  https://github.com/wlady
 * Description: WooCommerce Account Info Elementor Widget
 * Author:      Vladimir Zabara <wlady2001@gmail.com>
 * Author URI:  https://compoza.cet
 * Text Domain: account-info-plugin
 * Domain Path: /languages/
 * License:     GPL v3
 * Requires at least: 5.5
 * Requires PHP: 7.3.9
 *
 * PEP requires at least: 3.0
 * PEP tested up to: 5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

define( 'AIW_PLUGIN_DOMAIN', 'account-info-elementor-widget' );
define( 'AIW_PLUGIN_VERSION', '1.0.0');
define( 'AIW_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'AIW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'MINIMUM_ELEMENTOR_VERSION', '2.0.0' );
define( 'MINIMUM_PHP_VERSION', '7.0' );

//require AIW_PLUGIN_PATH . '/gutenberg/main.php';
//require AIW_PLUGIN_PATH . '/includes/main.php';
//require AIW_PLUGIN_PATH . '/woocommerce/main.php';
require AIW_PLUGIN_PATH . '/elementor/class-elementor.php';

add_action( 'after_setup_theme', 'pe_theme_setup' );

/**
 * Add woocommerce support to your theme.
 */
function pe_theme_setup() {
	add_theme_support( 'woocommerce' );
}