<?php

return [

    'enabled' => [
        'title' => __('Enable/Disable', 'woocommerce'),
        'type' => 'checkbox',
        'label' => __('Enable SimplePay', 'pine-simple-pay'),
    ],
    'title' => [
        'title' => __('Title', 'woocommerce'),
        'type' => 'text',
        'description' => __('This controls the title which the user sees during checkout.', 'woocommerce'),
        'default' => __('Credit Card', 'pine-simple-pay'),
        'desc_tip' => true,
    ],
    'description' => [
        'title' => __('Description', 'woocommerce'),
        'type' => 'text ',
        'description' => __('This controls the description which the user sees during checkout.', 'woocommerce'),
        'default' => __('Pay with credit card via SimplePay.', 'pine-simple-pay'),
        'desc_tip' => true,
    ],
    'pine_api_settings' => [
        'title'       => __('Pine API Settings', 'pine-simple-pay'),
        'type'        => 'title',
        'description' => __('Set you licens key to recieve updates for the plugin.'),
    ],
    'license_key' => [
        'title'       => __('License Key', 'pine-simple-pay'),
        'type'        => 'text',
        'description' => __('This is the license key what you can obtain at you pine store profile.', 'pine-simple-pay'),
        'desc_tip' => true,
    ],
    'sanbox_settings' => [
        'title'       => __('Sandbox Settings', 'pine-simple-pay'),
        'type'        => 'title',
        'description' => __('If this option is on this gateway is in test (sandbox) mode.', 'pine-simple-pay'),
    ],
    'sandbox' => [
        'title' => __('Enable/Disable', 'woocommerce'),
        'type' => 'checkbox',
        'label' => __('Enable Sandbox Mode', 'pine-simple-pay'),
    ],
    'notification_settings' => [
        'title'       => __('IPN / IRN settings', 'pine-simple-pay'),
        'type'        => 'title',
        'description' => sprintf('%s%s',
            __('Your IPN url:', 'pine-simple-pay'),
            ' <code>' . site_url() . '?wc-api=wc_gateway_pine-simple-pay</code>'
        ),
    ],
    'huf_settings' => [
        'title'       => __('HUF Mercant Settings', 'pine-simple-pay'),
        'type'        => 'title',
        'description' => __('Settings for HUF currency. These are activated when the customer checks out with HUF prices.', 'pine-simple-pay'),
    ],
    'huf_merchant' => [
        'title' => __('HUF Merchant ID', 'pine-simple-pay'),
        'type' => 'text ',
        'description' => __('This is the merchant ID for HUF currency.', 'pine-simple-pay'),
        'desc_tip' => true,
    ],
    'huf_secret_key' => [
        'title' => __('HUF Secret Key', 'pine-simple-pay'),
        'type' => 'password ',
        'description' => __('This is the secret key for HUF currency.', 'pine-simple-pay'),
        'desc_tip' => true,
    ],
    'eur_settings' => [
        'title'       => __('EUR Mercant Settings', 'pine-simple-pay'),
        'type'        => 'title',
        'description' => __('Settings for EUR currency. These are activated when the customer checks out with EUR prices.', 'pine-simple-pay'),
    ],
    'eur_merchant' => [
        'title' => __('EUR Merchant ID', 'pine-simple-pay'),
        'type' => 'text ',
        'description' => __('This is the merchant ID for EUR currency.', 'pine-simple-pay'),
        'desc_tip' => true,
    ],
    'eur_secret_key' => [
        'title' => __('EUR Secret Key', 'pine-simple-pay'),
        'type' => 'password ',
        'description' => __('This is the secret key for EUR currency.', 'pine-simple-pay'),
        'desc_tip' => true,
    ],
    'usd_settings' => [
        'title'       => __('USD Mercant Settings', 'pine-simple-pay'),
        'type'        => 'title',
        'description' => __('Settings for USD currency. These are activated when the customer checks out with USD prices.', 'pine-simple-pay'),
    ],
    'usd_merchant' => [
        'title' => __('USD Merchant ID', 'pine-simple-pay'),
        'type' => 'text ',
        'description' => __('This is the merchant ID for USD currency.', 'pine-simple-pay'),
        'desc_tip' => true,
    ],
    'usd_secret_key' => [
        'title' => __('USD Secret Key', 'pine-simple-pay'),
        'type' => 'password ',
        'description' => __('This is the secret key for USD currency.', 'pine-simple-pay'),
        'desc_tip' => true,
    ],
    'debug_settings' => [
        'title'       => __('Debug Settings', 'pine-simple-pay'),
        'type'        => 'title',
        'description' => '',
    ],
    'debug' => [
        'title' => __('Debug log', 'pine-simple-pay'),
        'type' => 'checkbox',
        'label' => __('Enable logging', 'pine-simple-pay'),
        'description' => sprintf('%s%s',
            __('Log SimplePay events, such as IPN requests, inside', 'pine-simple-pay'),
            " <code>" . WC_Log_Handler_File::get_log_file_path('pine-simple-pay') . "</code>."
        ),
    ],

];
