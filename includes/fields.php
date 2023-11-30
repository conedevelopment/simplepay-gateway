<?php

return [

    'enabled' => [
        'title' => __('Enable/Disable', 'woocommerce'),
        'type' => 'checkbox',
        'label' => __('Enable SimplePay', 'cone-simplepay'),
    ],

    'title' => [
        'title' => __('Title', 'woocommerce'),
        'type' => 'text',
        'description' => __('This controls the title which the user sees during checkout.', 'woocommerce'),
        'default' => __('Credit Card', 'cone-simplepay'),
        'desc_tip' => true,
    ],
    'description' => [
        'title' => __('Description', 'woocommerce'),
        'type' => 'text',
        'description' => __('This controls the description which the user sees during checkout.', 'woocommerce'),
        'default' => __('Pay with credit card via SimplePay.', 'cone-simplepay'),
        'desc_tip' => true,
    ],
    'prefix' => [
        'title' => __('Transaction Prefix', 'cone-simplepay'),
        'type' => 'text',
        'description' => __('This prefix will be prepended to the order.', 'cone-simplepay'),
        'default' => 'wc-',
        'desc_tip' => true,
    ],

    'notification_settings' => [
        'title' => __('IPN/IRN settings', 'cone-simplepay'),
        'type' => 'title',
        'description' => sprintf(
            '%s <code>%s</code>',
            __("The shop's IPN/IRN URL:", 'cone-simplepay'),
            add_query_arg(['wc-api' => 'wc_gateway_simplepay-gateway'], home_url('/'))
        ),
    ],

    'sandbox_settings' => [
        'title' => __('Sandbox Settings', 'cone-simplepay'),
        'type' => 'title',
        'description' => __('If this option is on this gateway is in test (sandbox) mode.', 'cone-simplepay'),
    ],
    'sandbox' => [
        'title' => __('Enable/Disable', 'woocommerce'),
        'type' => 'checkbox',
        'label' => __('Enable Sandbox Mode', 'cone-simplepay'),
        'class' => 'js-simplepay-sandbox-mode-checkbox',
    ],

    'two_step_settings' => [
        'title' => __('Two Step Payments', 'cone-simplepay'),
        'type' => 'title',
        'description' => __('If this option is on, two step payments are enabled.', 'cone-simplepay'),
    ],
    'two_step' => [
        'title' => __('Enable/Disable', 'woocommerce'),
        'type' => 'checkbox',
        'label' => __('Enable Two Step Payments', 'cone-simplepay'),
    ],

    'huf_settings' => [
        'title' => __('HUF Merchant Settings', 'cone-simplepay'),
        'type' => 'title',
        'description' => __('Settings for HUF currency. These are activated when the customer checks out with HUF prices.', 'cone-simplepay'),
    ],
    'huf_merchant' => [
        'title' => __('HUF Merchant ID', 'cone-simplepay'),
        'type' => 'text',
        'description' => __('This is the merchant ID for HUF currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'huf_secret_key' => [
        'title' => __('HUF Secret Key', 'cone-simplepay'),
        'type' => 'password',
        'description' => __('This is the secret key for HUF currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'huf_sandbox_merchant' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'cone-simplepay'), __('HUF Merchant ID', 'cone-simplepay')),
        'type' => 'text',
        'description' => __('This is the sandbox merchant ID for HUF currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],
    'huf_sandbox_secret_key' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'cone-simplepay'), __('HUF Secret Key', 'cone-simplepay')),
        'type' => 'password',
        'description' => __('This is the sandbox secret key for HUF currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],

    'eur_settings' => [
        'title' => __('EUR Merchant Settings', 'cone-simplepay'),
        'type' => 'title',
        'description' => __('Settings for EUR currency. These are activated when the customer checks out with EUR prices.', 'cone-simplepay'),
    ],
    'eur_merchant' => [
        'title' => __('EUR Merchant ID', 'cone-simplepay'),
        'type' => 'text',
        'description' => __('This is the merchant ID for EUR currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'eur_secret_key' => [
        'title' => __('EUR Secret Key', 'cone-simplepay'),
        'type' => 'password',
        'description' => __('This is the secret key for EUR currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'eur_sandbox_merchant' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'cone-simplepay'), __('EUR Merchant ID', 'cone-simplepay')),
        'type' => 'text',
        'description' => __('This is the sandbox merchant ID for EUR currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],
    'eur_sandbox_secret_key' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'cone-simplepay'), __('EUR Secret Key', 'cone-simplepay')),
        'type' => 'password',
        'description' => __('This is the sandbox secret key for EUR currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],

    'usd_settings' => [
        'title' => __('USD Merchant Settings', 'cone-simplepay'),
        'type' => 'title',
        'description' => __('Settings for USD currency. These are activated when the customer checks out with USD prices.', 'cone-simplepay'),
    ],
    'usd_merchant' => [
        'title' => __('USD Merchant ID', 'cone-simplepay'),
        'type' => 'text',
        'description' => __('This is the merchant ID for USD currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'usd_secret_key' => [
        'title' => __('USD Secret Key', 'cone-simplepay'),
        'type' => 'password',
        'description' => __('This is the secret key for USD currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-prod-field',
    ],
    'usd_sandbox_merchant' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'cone-simplepay'), __('USD Merchant ID', 'cone-simplepay')),
        'type' => 'text',
        'description' => __('This is the sandbox merchant ID for USD currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],
    'usd_sandbox_secret_key' => [
        'title' => sprintf('<span style="background-color: #ff3e3e; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; padding: 2px 4px; border-radius: 3px;">%s</span> %s', __('Sandbox', 'cone-simplepay'), __('USD Secret Key', 'cone-simplepay')),
        'type' => 'password',
        'description' => __('This is the sandbox secret key for USD currency.', 'cone-simplepay'),
        'desc_tip' => true,
        'class' => 'js-credential-input js-simplepay-sandbox-field',
    ],

    'icon_settings' => [
        'title' => __('Icon Settings', 'cone-simplepay'),
        'type' => 'title',
        'description' => '',
    ],
    'show_icon' => [
        'title' => __('Show SimplePay icon on checkout', 'cone-simplepay'),
        'type' => 'checkbox',
        'label' => __('Show icon', 'cone-simplepay'),
    ],

    'debug_settings' => [
        'title' => __('Debug Settings', 'cone-simplepay'),
        'type' => 'title',
        'description' => '',
    ],
    'debug' => [
        'title' => __('Debug log', 'cone-simplepay'),
        'type' => 'checkbox',
        'label' => __('Enable logging', 'cone-simplepay'),
        'description' => sprintf(
            '%s%s',
            __('Log SimplePay events, such as IPN requests, inside log files with the following prefix', 'cone-simplepay'),
            ': <code>simplepay-gateway</code>.'
        ),
    ],

];
