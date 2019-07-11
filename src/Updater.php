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
     * @param  array  $response
     * @param  string  $action
     * @param  object  $args
     * @return mixed
     */
    public function info($response, $action, $args)
    {
        if ($action !== 'plugin_information') {
            return false;
        } elseif (Plugin::SLUG !== $args->slug) {
		    return $response;
        } elseif (! $remote = get_transient('simplepay_update_' . Plugin::SLUG)) {
            $remote = wp_remote_get($this->url);

            if (wp_remote_retrieve_response_code($remote) == 200 && wp_remote_retrieve_body($remote)) {
                set_transient('simplepay_update_' . Plugin::SLUG, $remote, 43200);
            }
        }

        if ($remote) {
            $remote = json_decode(wp_remote_retrieve_body($remote));

            $res = new stdClass;
            $res->name = 'SimplePay Gateway for WooCommerce';
            $res->slug = Plugin::SLUG;
            $res->version = str_replace('v', '', $remote->tag_name);
            $res->tested = '5.2.2';
            $res->requires = '4.9.0';
            $res->author = '<a href="https://pineco.de">Pine</a>';
            $res->author_profile = 'https://pineco.de';
            $res->download_link = $remote->zipball_url;
            $res->trunk = $remote->zipball_url;
            $res->last_updated = date('Y-m-d H:i:s', strtotime($remote->published_at));
            $res->sections = [];

            return $res;
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
                $res = new stdClass;
                $res->slug = Plugin::SLUG;
                $res->plugin = Plugin::SLUG;
                $res->new_version = $version;
                $res->tested = '5.2.2';
                $res->package = $remote->zipball_url;
                $res->url = $remote->html_url;

                $transient->response[$res->plugin] = $res;
                $transient->checked[$res->plugin] = $remote->version;
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
