<?php

/**
 * Plugin Name:       SimplePay Gateway for WooCommerce
 * Plugin URI:        https://github.com/thepinecode/simplepay-gateway
 * Description:       SimplePay credit card gateway integration for Woocommerce.
 * Version:           1.0.0
 * Author:            Gergő D. Nagy
 * Author URI:        https://pineco.de
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       pine-simplepay
 * Domain Path:       /languages/
 */

/**
 * Get the plugin directory path.
 *
 * @param  string|null  $file
 * @return string
 */
function simplepay_gateway_path($file = '')
{
    return sprintf('%s%s', plugin_dir_path(__FILE__), $file);
}

/**
 * Get the plugin directory URL.
 *
 * @param  string|null  $file
 * @return string
 */
function simplepay_gateway_url($file = '')
{
    return sprintf('%s%s', plugin_dir_url(__FILE__), $file);
}

// Pull in the autoloader
require_once __DIR__ . '/autoload.php';

// Register the activation and the deactivation hooks
register_activation_hook(__FILE__, [Pine\SimplePay\Plugin::class, 'activate']);
register_deactivation_hook(__FILE__, [Pine\SimplePay\Plugin::class, 'deactivate']);

// Boot the plugin
Pine\SimplePay\Plugin::boot();
