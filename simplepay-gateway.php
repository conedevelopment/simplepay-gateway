<?php

/**
 * Plugin Name:       OTP SimplePay Gateway for WooCommerce
 * Plugin URI:        https://simplepay.conedevelopment.com/
 * Description:       OTP SimplePay payment gateway integration for WooCommerce.
 * Version:           2.8.0
 * Author:            Cone Development
 * Author URI:        https://conedevelopment.com
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       cone-simplepay
 * Domain Path:       /languages/
 * Requires at least: 5.2
 * Tested up to:      6.4.1
 * Requires PHP:      7.2
 * WC tested up to:   8.3.1
 */

// Pull in the autoloader
require_once __DIR__.'/autoload.php';

// Register the activation and the deactivation hooks
register_activation_hook(__FILE__, [Cone\SimplePay\Plugin::class, 'activate']);
register_deactivation_hook(__FILE__, [Cone\SimplePay\Plugin::class, 'deactivate']);

// Declare HPOS & Checkout Block compatibility
add_action('before_woocommerce_init', function () {
    if (class_exists(Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
        Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('cart_checkout_blocks', __FILE__, true);
    }
});

// Boot the plugin
Cone\SimplePay\Plugin::boot();
