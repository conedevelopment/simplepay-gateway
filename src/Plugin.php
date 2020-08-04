<?php

namespace Pine\SimplePay;

use Pine\SimplePay\Support\Config;
use WooCommerce;

class Plugin
{
    /**
     * The plugin version.
     *
     * @var string
     */
    public const VERSION = '2.4.0';

    /**
     * The plugin slug.
     *
     * @var string
     */
    public const SLUG = 'simplepay-gateway-master/simplepay-gateway.php';

    /**
     * Boot the plugin.
     *
     * @return void
     */
    public static function boot()
    {
        add_action('widgets_init', [__CLASS__, 'registerWidget']);
        add_action('plugins_loaded', [__CLASS__, 'bootGateway']);
        add_filter('plugin_action_links_'.static::SLUG, [__CLASS__, 'addLink']);
        add_filter('body_class', [__CLASS__, 'addBodyClass']);

        load_plugin_textdomain('pine-simplepay', false, basename(dirname(__DIR__)).'/languages');

        Config::boot(get_option('woocommerce_simplepay-gateway_settings', []));

        Updater::boot();
    }

    /**
     * Handle the deactivation.
     *
     * @return void
     */
    public static function deactivate()
    {
        //
    }

    /**
     * Handle the activation.
     *
     * @return void
     */
    public static function activate()
    {
        if (! class_exists(WooCommerce::class)) {
            die(__('Please activate WooCommerce before using SimplePay Gateway!', 'pine-simplepay'));
        }
    }

    /**
     * Add plugin settings link.
     *
     * @param  array  $links
     * @return array
     */
    public static function addLink($links)
    {
        $link = sprintf(
            '<a href="%s">%s</a>',
            admin_url('admin.php?page=wc-settings&tab=checkout&section=simplepay-gateway'),
            __('Settings')
        );

        return array_merge([$link], $links);
    }

    /**
     * Register the logo widget.
     *
     * @return void
     */
    public static function registerWidget()
    {
        register_widget(Widget::class);
    }

    /**
     * Boot the gateway if woocommerce is active.
     *
     * @return void
     */
    public static function bootGateway()
    {
        if (class_exists(WooCommerce::class)) {
            Gateway::boot();
        }
    }

    /**
     * Add the custom class to the <body> tag.
     *
     * @param  array  $classes
     * @return array
     */
    public static function addBodyClass($classes)
    {
        return array_merge($classes, ['pine-simplepay-gateway']);
    }
}
