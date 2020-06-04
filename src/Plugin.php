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
    public const VERSION = '2.3.1';

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
        Config::boot(get_option('woocommerce_simplepay-gateway_settings', []));

        add_action('widgets_init', [__CLASS__, 'registerWidget']);
        add_filter('pre_update_option_active_plugins', [__CLASS__, 'guard']);
        add_filter('plugin_action_links_'.static::SLUG, [__CLASS__, 'addLinks']);

        load_plugin_textdomain('pine-simplepay', false, basename(dirname(__DIR__)).'/languages');

        if (class_exists(WooCommerce::class)) {
            Gateway::boot();
        }

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
     * Guard the plugins order to make sure everything works.
     *
     * @param  array  $plugins
     * @return array
     */
    public static function guard($plugins)
    {
        if (($index = array_search(static::SLUG, $plugins)) !== false) {
            unset($plugins[$index]);
            $plugins[] = static::SLUG;
        }

        return $plugins;
    }

    /**
     * Add plugin settings link.
     *
     * @param  array  $links
     * @return array
     */
    public static function addLinks($links)
    {
        return array_merge([
            sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=wc-settings&tab=checkout&section=simplepay-gateway'), __('Settings')),
        ], $links);
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
}
