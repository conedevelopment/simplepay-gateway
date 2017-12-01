<?php

return [

    'enabled' => [
        'title' => __('Enable/Disable', 'woocommerce'),
        'type' => 'checkbox',
        'label' => __('Enable SimplePay', 'pine-simplepay'),
    ],
    'title' => [
        'title' => __('Title', 'woocommerce'),
        'type' => 'text',
        'description' => __('This controls the title which the user sees during checkout.', 'woocommerce'),
        'default' => __('Credit Card', 'pine-simplepay'),
        'desc_tip' => true,
    ],
    'description' => [
        'title' => __('Description', 'woocommerce'),
        'type' => 'text ',
        'description' => __('This controls the description which the user sees during checkout.', 'woocommerce'),
        'default' => __('Pay with credit card via SimplePay.', 'pine-simplepay'),
        'desc_tip' => true,
    ],
    'pine_api_settings' => [
        'title'       => __('Pine API Settings', 'pine-simplepay'),
        'type'        => 'title',
        'description' => __('Set you licens key to recieve updates for the plugin.'),
    ],
    'license_key' => [
        'title'       => __('License Key', 'pine-simplepay'),
        'type'        => 'text',
        'description' => __('This is the license key what you can obtain at you pine store profile.', 'pine-simplepay'),
        'desc_tip' => true,
    ],
    'sanbox_settings' => [
        'title'       => __('Sandbox Settings', 'pine-simplepay'),
        'type'        => 'title',
        'description' => __('If this option is on this gateway is in test (sandbox) mode.', 'pine-simplepay'),
    ],
    'sandbox' => [
        'title' => __('Enable/Disable', 'woocommerce'),
        'type' => 'checkbox',
        'label' => __('Enable Sandbox Mode', 'pine-simplepay'),
    ],
    'notification_settings' => [
        'title'       => __('IPN / IRN settings', 'pine-simplepay'),
        'type'        => 'title',
        'description' => sprintf('%s%s',
            __('Your IPN url:', 'pine-simplepay'),
            ' <code>' . site_url() . '?wc-api=wc_gateway_pine-simplepay</code>'
        ),
    ],
    'huf_settings' => [
        'title'       => __('HUF Mercant Settings', 'pine-simplepay'),
        'type'        => 'title',
        'description' => __('Settings for HUF currency. These are activated when the customer checks out with HUF prices.', 'pine-simplepay'),
    ],
    'huf_merchant' => [
        'title' => __('HUF Merchant ID', 'pine-simplepay'),
        'type' => 'text ',
        'description' => __('This is the merchant ID for HUF currency.', 'pine-simplepay'),
        'desc_tip' => true,
    ],
    'huf_secret_key' => [
        'title' => __('HUF Secret Key', 'pine-simplepay'),
        'type' => 'password ',
        'description' => __('This is the secret key for HUF currency.', 'pine-simplepay'),
        'desc_tip' => true,
    ],
    'eur_settings' => [
        'title'       => __('EUR Mercant Settings', 'pine-simplepay'),
        'type'        => 'title',
        'description' => __('Settings for EUR currency. These are activated when the customer checks out with EUR prices.', 'pine-simplepay'),
    ],
    'eur_merchant' => [
        'title' => __('EUR Merchant ID', 'pine-simplepay'),
        'type' => 'text ',
        'description' => __('This is the merchant ID for EUR currency.', 'pine-simplepay'),
        'desc_tip' => true,
    ],
    'eur_secret_key' => [
        'title' => __('EUR Secret Key', 'pine-simplepay'),
        'type' => 'password ',
        'description' => __('This is the secret key for EUR currency.', 'pine-simplepay'),
        'desc_tip' => true,
    ],
    'usd_settings' => [
        'title'       => __('USD Mercant Settings', 'pine-simplepay'),
        'type'        => 'title',
        'description' => __('Settings for USD currency. These are activated when the customer checks out with USD prices.', 'pine-simplepay'),
    ],
    'usd_merchant' => [
        'title' => __('USD Merchant ID', 'pine-simplepay'),
        'type' => 'text ',
        'description' => __('This is the merchant ID for USD currency.', 'pine-simplepay'),
        'desc_tip' => true,
    ],
    'usd_secret_key' => [
        'title' => __('USD Secret Key', 'pine-simplepay'),
        'type' => 'password ',
        'description' => __('This is the secret key for USD currency.', 'pine-simplepay'),
        'desc_tip' => true,
    ],
    'debug_settings' => [
        'title'       => __('Debug Settings', 'pine-simplepay'),
        'type'        => 'title',
        'description' => '',
    ],
    'debug' => [
        'title' => __('Debug log', 'pine-simplepay'),
        'type' => 'checkbox',
        'label' => __('Enable logging', 'pine-simplepay'),
        'description' => sprintf('%s%s',
            __('Log SimplePay events, such as IPN requests, inside', 'pine-simplepay'),
            " <code>" . WC_Log_Handler_File::get_log_file_path('pine-simplepay') . "</code>."
        ),
    ],

];
