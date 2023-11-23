<?php

namespace Cone\SimplePay;
use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

final class GatewayBlock extends AbstractPaymentMethodType {
	private $gateway;
	protected $name = 'simplepay-gateway';

	public function initialize() {
		$this->settings = get_option( 'woocommerce_simplepay-gateway_settings', [] );
		$this->gateway = new Gateway();
	}

	public function is_active() {
		return $this->get_setting( 'enabled' ) === 'yes';
	}

	public function get_payment_method_script_handles() {
		wp_register_script(
			'simplepay-gateway-blocks-integration',
			plugin_dir_url(__DIR__). 'includes/checkout.js',
			[
				'wc-blocks-registry',
				'wc-settings',
				'wp-element',
				'wp-html-entities',
				'wp-i18n',
			],
			null,
			true
		);
		if( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'simplepay-gateway-blocks-integration');
		}

		return [ 'simplepay-gateway-blocks-integration' ];
	}

	public function get_payment_method_data() {
		return [
			'title' => $this->gateway->title,
			'description' => $this->gateway->description,
			'icon' => $this->gateway->icon
		];
	}

}
