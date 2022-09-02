<?php

/**
 * Plugin Name:       OTP SimplePay Gateway for WooCommerce
 * Plugin URI:        https://simplepay.conedevelopment.com/
 * Description:       OTP SimplePay payment gateway integration for WooCommerce.
 * Version:           2.5.2
 * Author:            Cone Development
 * Author URI:        https://conedevelopment.com
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       cone-simplepay
 * Domain Path:       /languages/
 * Requires at least: 5.1
 * Tested up to:      5.7.2
 * Requires PHP:      7.2
 * WC tested up to:   5.4.1
 */

// Pull in the autoloader
require_once __DIR__.'/autoload.php';

// Register the activation and the deactivation hooks
register_activation_hook(__FILE__, [Cone\SimplePay\Plugin::class, 'activate']);
register_deactivation_hook(__FILE__, [Cone\SimplePay\Plugin::class, 'deactivate']);

// Boot the plugin
Cone\SimplePay\Plugin::boot();
