<?php

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

/**
 * AIW_Elementor class.
 *
 * The init class that runs the Elementor plugin.
 * You should only modify the constants to match your plugin's needs.
 */
final class AIW_Elementor {
	/**
	 * AIW_Elementor constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Load the translation.
		add_action( 'init', array( $this, 'i18n' ) );

		// Initialize the plugin.
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( AIW_PLUGIN_DOMAIN );
	}

	/**
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// We have passed all validation checks and now we can safely include our widgets.
		require_once AIW_PLUGIN_PATH. 'elementor/class-widgets.php';
	}

	/**
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
//		deactivate_plugins( plugin_basename( PE_FILE ) );

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', AIW_PLUGIN_DOMAIN ),
			'<strong>' . esc_html__( 'WC Account Info For Elementor', AIW_PLUGIN_DOMAIN ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', AIW_PLUGIN_DOMAIN ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
//		deactivate_plugins( plugin_basename( PE_FILE ) );

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', AIW_PLUGIN_DOMAIN ),
			'<strong>' . esc_html__( 'WC Account Info For Elementor', AIW_PLUGIN_DOMAIN ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', AIW_PLUGIN_DOMAIN ) . '</strong>',
			'<strong>' . esc_html__( MINIMUM_ELEMENTOR_VERSION, AIW_PLUGIN_DOMAIN ) . '</strong>',
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
//		deactivate_plugins( plugin_basename( PE_FILE ) );

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', AIW_PLUGIN_DOMAIN ),
			'<strong>' . esc_html__( 'WC Account Info For Elementor', AIW_PLUGIN_DOMAIN ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', AIW_PLUGIN_DOMAIN ) . '</strong>',
			'<strong>' . esc_html__( MINIMUM_PHP_VERSION, AIW_PLUGIN_DOMAIN ) . '</strong>',
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

// Instantiate AIW_Elementor.
new AIW_Elementor;