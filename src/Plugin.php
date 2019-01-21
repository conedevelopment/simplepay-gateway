<?php

namespace Pine\SimplePay;

use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Modules\Gateway;

class Plugin
{
    /**
     * Determine if the plugin is active.
     *
     * @var bool
     */
    protected static $isActive = true;

    /**
     * The plugin modules.
     *
     * @var array
     */
    protected static $modules = [
        Modules\Gateway::class,
    ];

    /**
     * Boot the plugin.
     *
     * @return void
     */
    public static function boot()
    {
        static::configure();

        add_filter('pre_update_option_active_plugins', [__CLASS__, 'guard']);
        add_filter('plugin_action_links_pine-simplepay/pine-simplepay.php', [__CLASS__, 'addLinks']);

        if (static::isActiveWooCommerce()) {
            foreach (static::$modules as $module) {
                (new $module)->registerHooks();
            }
        }
    }

    /**
     * Load the settings and configure the plugin.
     *
     * @return void
     */
    protected static function configure()
    {
        Config::boot(get_option('woocommerce_pine-simplepay_settings') ?: []);
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
        if (! static::isActiveWooCommerce()) {
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
        if (static::$isActive) {
            unset($plugins[array_search('pine-simplepay/pine-simplepay.php', $plugins)]);
            $plugins[] = 'pine-simplepay/pine-simplepay.php';
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
            sprintf("<a href='%s'>%s</a>", admin_url('admin.php?page=wc-settings&tab=checkout&section=pine-simplepay'), __('Settings')),
        ]);
    }

    /**
     * Check if WooCommerce is activated.
     *
     * @return bool
     */
    protected static function isActiveWooCommerce()
    {
        return class_exists('WooCommerce');
    }
}
