<?php

/**
 * Plugin Name:       SimplePay Gateway for WooCommerce
 * Plugin URI:        https://github.com/thepinecode/simplepay-gateway
 * Description:       SimplePay credit card gateway integration for WooCommerce.
 * Version:           2.1.0
 * Author:            Pine
 * Author URI:        https://pineco.de
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       pine-simplepay
 * Domain Path:       /languages/
 */

// Pull in the autoloader
require_once __DIR__.'/autoload.php';

// Register the activation and the deactivation hooks
register_activation_hook(__FILE__, [Pine\SimplePay\Plugin::class, 'activate']);
register_deactivation_hook(__FILE__, [Pine\SimplePay\Plugin::class, 'deactivate']);

// Boot the plugin
Pine\SimplePay\Plugin::boot();
