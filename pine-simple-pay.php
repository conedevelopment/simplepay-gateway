<?php

/**
 * Plugin Name:       SimplePay Gateway for WooCommerce
 * Plugin URI:        https://pineco.de/projects/simple-pay-gateway
 * Description:       SimplePay Credit Card Gateway integration with Woocommerce.
 * Version:           0.1.0
 * Author:            Gergő D. Nagy
 * Author URI:        https://pineco.de
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       pine-simple-pay
 * Domain Path:       /languages/
 */

/**
 * Get the plugin directory path.
 *
 * @return string
 */
if (! function_exists('pine_path')):
    function pine_path($file = '')
    {
        return sprintf('%s%s', plugin_dir_path(__FILE__), $file);
    }
endif;

/**
 * Get the plugin directory URL.
 *
 * @return string
 */
if (! function_exists('pine_url')):
    function pine_url($file = '')
    {
        return sprintf('%s%s', plugin_dir_url(__FILE__), $file);
    }
endif;

// Pull in the autoloader
require_once __DIR__.'/bootstrap/autoloader.php';

// Register the deactivation hook
register_deactivation_hook(__FILE__, [Pine\SimplePay\SimplePay::class, 'deactivate']);

// Boot up the servicies
Pine\SimplePay\SimplePay::boot();
