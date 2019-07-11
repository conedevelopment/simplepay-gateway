<?php

namespace Pine\SimplePay;

use stdClass;

class Updater
{
    /**
     * The repo URL.
     *
     * @var string
     */
    protected $url = 'https://api.github.com/repos/thepinecode/simplepay-gateway/releases/latest';

    /**
     * Get the plugin info.
     *
     * @param  array  $infoponse
     * @param  string  $action
     * @param  object  $args
     * @return mixed
     */
    public function info($infoponse, $action, $args)
    {
        if ($action !== 'plugin_information') {
            return false;
        } elseif (Plugin::SLUG !== $args->slug) {
		    return $infoponse;
        } elseif (! $infoponse = get_transient('simplepay_update_' . Plugin::SLUG)) {
            $remote = wp_remote_get($this->url);

            if (wp_remote_retrieve_response_code($remote) == 200 && wp_remote_retrieve_body($remote)) {
                set_transient('simplepay_update_' . Plugin::SLUG, $remote, 43200);
            }
        }

        if ($remote) {
            $remote = json_decode(wp_remote_retrieve_body($remote));

            $info = new stdClass;
            $info->name = 'SimplePay Gateway for WooCommerce';
            $info->slug = Plugin::SLUG;
            $info->version = str_replace('v', '', $remote->tag_name);
            $info->tested = '5.2.2';
            $info->requires = '4.9.0';
            $info->author = '<a href="https://pineco.de">Pine</a>';
            $info->author_profile = 'https://pineco.de';
            $info->download_link = $remote->zipball_url;
            $info->trunk = $remote->zipball_url;
            $info->last_updated = date('Y-m-d H:i:s', strtotime($remote->published_at));
            $info->sections = [];

            return $info;
        }

        return false;
    }

    /**
     * Run the updater.
     *
     * @param  object  $transient
     * @return mixed
     */
    public function update($transient)
    {
        if (! $transient->checked) {
            return $transient;
        } elseif (! $remote = get_transient('simplepay_update_' . Plugin::SLUG)) {
            $remote = wp_remote_get($this->url);

            if (wp_remote_retrieve_response_code($remote) == 200 && wp_remote_retrieve_body($remote)) {
                set_transient('simplepay_update_' . Plugin::SLUG, $remote, 43200);
            }
        }

        if ($remote) {
            $remote = json_decode(wp_remote_retrieve_body($remote));

            if (version_compare(Plugin::VERSION, $version = str_replace('v', '', $remote->tag_name), '<')) {
                $info = new stdClass;
                $info->slug = Plugin::SLUG;
                $info->plugin = Plugin::SLUG;
                $info->new_version = $version;
                $info->tested = '5.2.2';
                $info->package = $remote->zipball_url;
                $info->url = $remote->html_url;

                $transient->response[$info->plugin] = $info;
                $transient->checked[$info->plugin] = $remote->version;
            }
        }

        return $transient;
    }

    /**
     * Clean the transient after update.
     *
     * @param  object  $updater
     * @param  array  $options
     */
    public function clean($updater, $options)
    {
        if ($options['action'] === 'update' && $options['type'] === 'plugin') {
            delete_transient('simplepay_update_' . Plugin::SLUG);
        }

        foreach ($options['plugins'] as $plugin) {
            if ($plugin === Plugin::SLUG && $dir = glob(WP_PLUGIN_DIR .'/thepinecode-simplepay-gateway*', GLOB_ONLYDIR)) {
                rename($dir[0], WP_PLUGIN_DIR . '/thepinecode-simplepay-gateway');
            }
        }
    }

    /**
     * Register the hooks.
     *
     * @return void
     */
    public function registerHooks()
    {
        add_filter('plugins_api', [$this, 'info'], 20, 3);
        add_filter('site_transient_update_plugins', [$this, 'update']);
        add_action('upgrader_process_complete', [$this, 'clean'], 10, 2);
    }
}
