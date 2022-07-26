<?php

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

class Account_Info_Widget extends Widget_Base {

	/**
	 * Get the widget's name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'account-info-plugin';
	}

	/**
	 * Get the widget's title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'WC Account Info', AIW_PLUGIN_DOMAIN );
	}

	/**
	 * Get the widget's icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'fa fa-user';
	}

	/**
	 * Add the widget to a category.
	 * Previously setup in the class-widgets.php file.
	 *
	 * @return string[]
	 */
	public function get_categories(): array {
		return [ 'woocommerce' ];
	}


	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'WC Account Info', AIW_PLUGIN_DOMAIN ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'aiw-no-controls',
			[
				'label' => __( 'No controls', AIW_PLUGIN_DOMAIN ),
				'type' => Controls_Manager::RAW_HTML,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if (Plugin::$instance->editor->is_edit_mode()) {
			// If the Elementor editor is opened.
		}

		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			$customer = new WC_Customer( $current_user->ID );
            ?>
			<div class="account-info-elementor-widget">
                <div><img src="<?= $customer->get_avatar_url(); ?>" class="account-info-elementor-widget-avatar"/></div>
                <h1 class="account-info-elementor-widget-name"><?php printf( esc_html__( 'Hello %s,', 'woocommerce' ), esc_html( $customer->get_display_name() ) ); ?></h1>
			</div>
		<?php
        }
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Account_Info_Widget() );