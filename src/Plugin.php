<?php

namespace Pine\SimplePay;

use Pine\SimplePay\Support\Config;

class Plugin
{
    /**
     * Determine if the plugin is active.
     *
     * @var bool
     */
    protected static $isActive = true;

    /**
     * Boot the plugin.
     *
     * @return void
     */
    public static function boot()
    {
        static::configure();

        add_action('widgets_init', [__CLASS__, 'registerWidget']);
        add_filter('pre_update_option_active_plugins', [__CLASS__, 'guard']);
        add_filter('plugin_action_links_simplepay-gateway/simplepay-gateway.php', [__CLASS__, 'addLinks']);

        if (class_exists('WooCommerce')) {
            (new Gateway)->registerHooks();
        }
    }

    /**
     * Load the settings and configure the plugin.
     *
     * @return void
     */
    protected static function configure()
    {
        Config::boot(get_option('woocommerce_simplepay-gateway_settings') ?: []);
    }

    /**
     * Handle the deactivation.
     *
     * @return void
     */
    public static function deactivate()
    {
        static::$isActive = false;
    }

    /**
     * Handle the activation.
     *
     * @return void
     */
    public static function activate()
    {
        if (! class_exists('WooCommerce')) {
            die(__('Please activate WooCommerce before using SimplePay Gateway!', 'simplepay-gateway'));
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
        if (static::$isActive) {
            unset($plugins[array_search('simplepay-gateway/simplepay-gateway.php', $plugins)]);
            $plugins[] = 'simplepay-gateway/simplepay-gateway.php';
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
        return array_merge($links, [
            sprintf("<a href='%s'>%s</a>", admin_url('admin.php?page=wc-settings&tab=checkout&section=simplepay-gateway'), __('Settings')),
        ]);
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
