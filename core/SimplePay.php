<?php

namespace Pine\SimplePay;

use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Modules\Gateway;

class SimplePay
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
        Modules\Updater::class,
    ];

    /**
     * Boot the plugin.
     *
     * @return void
     */
    public static function boot()
    {
        self::configure();

        add_filter('pre_update_option_active_plugins', [__CLASS__, 'guard']);
        add_filter('plugin_action_links_pine-simple-pay/pine-simple-pay.php', [__CLASS__, 'addLinks']);

        if (self::isActiveWooCommerce()) {
            foreach (self::$modules as $module) {
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
        Config::boot(get_option('woocommerce_pine-simple-pay_settings') ?: []);
    }

    /**
     * Handle the deactivation.
     *
     * @return void
     */
    public static function deactivate()
    {
        self::$isActive = false;
    }

    /**
     * Handle the activation.
     *
     * @return void
     */
    public static function activate()
    {
        if (! self::isActiveWooCommerce()) {
            die(__('Please activate WooCommerce before using SimplePay Gateway!', 'pine-simple-pay'));
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
        if (self::$isActive) {
            unset($plugins[array_search('pine-simple-pay/pine-simple-pay.php', $plugins)]);
            $plugins[] = 'pine-simple-pay/pine-simple-pay.php';
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
            sprintf("<a href='%s'>%s</a>", admin_url('admin.php?page=wc-settings&tab=checkout&section=pine-simple-pay'), __('Settings')),
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
