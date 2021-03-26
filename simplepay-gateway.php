<?php

/**
 * Plugin Name:       OTP SimplePay Gateway for WooCommerce
 * Plugin URI:        https://simplepay.conedevelopment.com/
 * Description:       OTP SimplePay payment gateway integration for WooCommerce.
 * Version:           2.4.11
 * Author:            Cone Development
 * Author URI:        https://conedevelopment.com
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       pine-simplepay
 * Domain Path:       /languages/
 * Requires at least: 5.1
 * Tested up to:      5.6.1
 * Requires PHP:      7.0
 * WC tested up to:   5.0.0
 */

// Pull in the autoloader
require_once __DIR__.'/autoload.php';

// Register the activation and the deactivation hooks
register_activation_hook(__FILE__, [Pine\SimplePay\Plugin::class, 'activate']);
register_deactivation_hook(__FILE__, [Pine\SimplePay\Plugin::class, 'deactivate']);

// Boot the plugin
Pine\SimplePay\Plugin::boot();
