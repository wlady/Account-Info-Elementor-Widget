<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
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
		return 'pe-latest-posts';
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
		return 'fa fa-clipboard';
	}

	/**
	 * Add the widget to a category.
	 * Previously setup in the class-widgets.php file.
	 *
	 * @return string[]
	 */
	public function get_categories(): array {
		return [ 'pe-category' ];
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
			'pe-no-posts-message',
			[
				'label' => __( 'Account', 'account-info-elementor-widget' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'No controls'
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if (Plugin::$instance->editor->is_edit_mode()) {
			// If the Elementor editor is opened.

		}

		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => 6,
			'orderby' => 'date',
		);

		$cpt = new WP_Query($args);
		$posts = $cpt->posts;

		if ( is_user_logged_in() /*&& is_account_page()*/ ) :
			$current_user = wp_get_current_user();
			$customer = new WC_Customer( $current_user->ID );
            ?>
			<div class="account-info-elementor-widget">
                <div><img src="<?= $customer->get_avatar_url(); ?>" class="account-info-elementor-widget-avatar"/></div>
                <h1 class="account-info-elementor-widget-name"><?php printf( esc_html__( 'Hello %s,', 'woocommerce' ), esc_html( $customer->get_display_name() ) ); ?></h1>
			</div>
		<?php endif;
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Account_Info_Widget() );