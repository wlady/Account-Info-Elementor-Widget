<?php

// We check if the Elementor plugin has been installed / activated.
if ( ! in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	return;
}

/**
 * Include the widgets and create a custom category.
 *
 * @package AIWElementor
 *
 * @since 1.0.0
 */
class AIW_Elementor_Widget {

	private static $instance = null;

	/**
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );

		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_frontend_scripts' ), 10 );

		add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_frontend_styles' ), 10 );

		add_action( 'elementor/elements/categories_registered', array( $this, 'elementor_widget_categories' ) );
	}

	/**
	 * Register the widgets.
	 *
	 * @since 1.0.0
	 */
	public function widgets_registered() {
		//Require all PHP files in the /elementor/widgets directory
		foreach ( glob( AIW_PLUGIN_PATH . "elementor/widgets/*.php" ) as $file ) {
			require $file;
		}
	}

	/**
	 * Register the scripts.
	 *
	 * @since 1.0.0
	 */
	public function register_frontend_scripts() {
		wp_enqueue_script( 'account-info-elementor-widget', AIW_PLUGIN_URL . 'elementor/assets/js/account-info-elementor-widget.js', array( 'jquery' ), AIW_PLUGIN_VERSION, true );
	}

	/**
	 * Register the styles.
	 *
	 * @since 1.0.0
	 */
	public function register_frontend_styles() {
		wp_enqueue_style( 'account-info-elementor-widget', AIW_PLUGIN_URL . 'elementor/assets/css/account-info-elementor-widget.css', null, AIW_PLUGIN_VERSION );
	}


	/**
	 * Custom elementor dashboard widgets category.
	 * The widgets will be visible here.
	 *
	 * @since 1.0.0
	 *
	 * @param $elements_manager
	 */
	public function elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'woocommerce',
			[
				'title' => esc_html__( 'Woocommerce', 'woocommerce' ),
				'icon'  => 'fa fa-user',
			]
		);
	}
}

AIW_Elementor_Widget::get_instance()->init();