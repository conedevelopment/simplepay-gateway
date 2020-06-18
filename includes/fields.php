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
        'type' => 'text',
        'description' => __('This controls the description which the user sees during checkout.', 'woocommerce'),
        'default' => __('Pay with credit card via SimplePay.', 'pine-simplepay'),
        'desc_tip' => true,
    ],
    'prefix' => [
        'title' => __('Transaction Prefix', 'pine-simplepay'),
        'type' => 'text',
        'description' => __('This prefix will be prepended to the order.', 'pine-simplepay'),
        'default' => 'wc-',
        'desc_tip' => true,
    ],

    'notification_settings' => [
        'title' => __('IPN/IRN settings', 'pine-simplepay'),
        'type' => 'title',
        'description' => sprintf('%s <code>%s</code>',
            __("The shop's IPN/IRN URL:", 'pine-simplepay'),
            add_query_arg(['wc-api' => 'wc_gateway_simplepay-gateway'], home_url())
        ),
    ],

    'sanbox_settings' => [
        'title' => __('Sandbox Settings', 'pine-simplepay'),
        'type' => 'title',
        'description' => __('If this option is on this gateway is in test (sandbox) mode.', 'pine-simplepay'),
    ],
    'sandbox' => [
        'title' => __('Enable/Disable', 'woocommerce'),
        'type' => 'checkbox',
        'label' => __('Enable Sandbox Mode', 'pine-simplepay'),
        'class' => 'js-simplepay-sandbox-mode-checkbox',
    ],

    'huf_settings' => [
        'title' => __('HUF Merchant Settings', 'pine-simplepay'),
        'type' => 'title',
        'description' => __('Settings for HUF currency. These are activated when the customer checks out with HUF prices.', 'pine-simplepay'),
    ],
    'huf_merchant' => [
        'title' => __('HUF Merchant ID', 'pine-simplepay'),
        'type' => 'text',
        'description' => __('This is the merchant ID for HUF currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'huf_secret_key' => [
        'title' => __('HUF Secret Key', 'pine-simplepay'),
        'type' => 'password',
        'description' => __('This is the secret key for HUF currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'huf_sandbox_merchant' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'pine-simplepay'), __('HUF Merchant ID', 'pine-simplepay')),
        'type' => 'text',
        'description' => __('This is the sandbox merchant ID for HUF currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],
    'huf_sandbox_secret_key' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'pine-simplepay'), __('HUF Secret Key', 'pine-simplepay')),
        'type' => 'password',
        'description' => __('This is the sandbox secret key for HUF currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],

    'eur_settings' => [
        'title' => __('EUR Merchant Settings', 'pine-simplepay'),
        'type' => 'title',
        'description' => __('Settings for EUR currency. These are activated when the customer checks out with EUR prices.', 'pine-simplepay'),
    ],
    'eur_merchant' => [
        'title' => __('EUR Merchant ID', 'pine-simplepay'),
        'type' => 'text',
        'description' => __('This is the merchant ID for EUR currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'eur_secret_key' => [
        'title' => __('EUR Secret Key', 'pine-simplepay'),
        'type' => 'password',
        'description' => __('This is the secret key for EUR currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'eur_sandbox_merchant' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'pine-simplepay'), __('EUR Merchant ID', 'pine-simplepay')),
        'type' => 'text',
        'description' => __('This is the sandbox merchant ID for EUR currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],
    'eur_sandbox_secret_key' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'pine-simplepay'), __('EUR Secret Key', 'pine-simplepay')),
        'type' => 'password',
        'description' => __('This is the sandbox secret key for EUR currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],

    'usd_settings' => [
        'title' => __('USD Merchant Settings', 'pine-simplepay'),
        'type' => 'title',
        'description' => __('Settings for USD currency. These are activated when the customer checks out with USD prices.', 'pine-simplepay'),
    ],
    'usd_merchant' => [
        'title' => __('USD Merchant ID', 'pine-simplepay'),
        'type' => 'text',
        'description' => __('This is the merchant ID for USD currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'usd_secret_key' => [
        'title' => __('USD Secret Key', 'pine-simplepay'),
        'type' => 'password',
        'description' => __('This is the secret key for USD currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'usd_sandbox_merchant' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'pine-simplepay'), __('USD Merchant ID', 'pine-simplepay')),
        'type' => 'text',
        'description' => __('This is the sandbox merchant ID for USD currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],
    'usd_sandbox_secret_key' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'pine-simplepay'), __('USD Secret Key', 'pine-simplepay')),
        'type' => 'password',
        'description' => __('This is the sandbox secret key for USD currency.', 'pine-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],

    'debug_settings' => [
        'title' => __('Debug Settings', 'pine-simplepay'),
        'type' => 'title',
        'description' => '',
    ],
    'debug' => [
        'title' => __('Debug log', 'pine-simplepay'),
        'type' => 'checkbox',
        'label' => __('Enable logging', 'pine-simplepay'),
        'description' => sprintf('%s%s',
            __('Log SimplePay events, such as IPN requests, inside log files with the following prefix', 'pine-simplepay'),
            ': <code>simplepay-gateway</code>.'
        ),
    ],

];
