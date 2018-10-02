<?php

/**
 * Plugin Name:       SimplePay Gateway for WooCommerce
 * Plugin URI:        https://github.com/thepinecode/simplepay-gateway
 * Description:       SimplePay credit card gateway integration for Woocommerce.
 * Version:           0.3.0
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
 * @return string
 */
if (! function_exists('simplepay_gateway_path')):
    function simplepay_gateway_path($file = '')
    {
        return sprintf('%s%s', plugin_dir_path(__FILE__), $file);
    }
endif;

/**
 * Get the plugin directory URL.
 *
 * @return string
 */
if (! function_exists('simplepay_gateway_url')):
    function simplepay_gateway_url($file = '')
    {
        return sprintf('%s%s', plugin_dir_url(__FILE__), $file);
    }
endif;

// Pull in the autoloader
require_once __DIR__.'/bootstrap/autoloader.php';

// Register the deactivation hook
register_activation_hook(__FILE__, [Pine\SimplePay\SimplePay::class, 'activate']);
register_deactivation_hook(__FILE__, [Pine\SimplePay\SimplePay::class, 'deactivate']);

// Boot up the servicies
Pine\SimplePay\SimplePay::boot();
