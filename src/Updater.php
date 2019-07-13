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
        } elseif (! $response = get_transient('simplepay_update_' . Plugin::SLUG)) {
            $response = wp_remote_get($this->url);

            if (wp_remote_retrieve_response_code($response) == 200 && wp_remote_retrieve_body($response)) {
                set_transient('simplepay_update_' . Plugin::SLUG, $response, 43200);
            }
        }

        if ($response) {
            $response = json_decode(wp_remote_retrieve_body($response));

            $info = new stdClass;
            $info->name = 'SimplePay Gateway for WooCommerce';
            $info->slug = Plugin::SLUG;
            $info->version = str_replace('v', '', $response->tag_name);
            $info->tested = '5.2.2';
            $info->requires = '4.9.0';
            $info->author = '<a href="https://pineco.de">Pine</a>';
            $info->author_profile = 'https://pineco.de';
            $info->download_link = $response->zipball_url;
            $info->trunk = $response->zipball_url;
            $info->last_updated = date('Y-m-d H:i:s', strtotime($response->published_at));
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
        } elseif (! $response = get_transient('simplepay_update_' . Plugin::SLUG)) {
            $response = wp_remote_get($this->url);

            if (wp_remote_retrieve_response_code($response) == 200 && wp_remote_retrieve_body($response)) {
                set_transient('simplepay_update_' . Plugin::SLUG, $response, 43200);
            }
        }

        if ($response) {
            $response = json_decode(wp_remote_retrieve_body($response));

            if (version_compare(Plugin::VERSION, $version = substr($response->tag_name, 1), '<')) {
                $info = new stdClass;
                $info->slug = Plugin::SLUG;
                $info->plugin = Plugin::SLUG;
                $info->new_version = $version;
                $info->tested = '5.2.2';
                $info->package = $response->zipball_url;
                $info->url = $response->html_url;

                $transient->response['plugin'] = $info;
                $transient->checked['plugin'] = $version;
            }
        }

        return $transient;
    }

    /**
     * Clean the transient and rename the directory after update.
     *
     * @param  object  $updater
     * @param  array  $options
     */
    public function clean($updater, $options)
    {
        if ($options['action'] === 'update' && $options['type'] === 'plugin') {
            delete_transient('simplepay_update_' . Plugin::SLUG);

            $dir = glob(WP_PLUGIN_DIR . '/*simplepay-gateway*', GLOB_ONLYDIR);

            if (array_search(Plugin::SLUG, $options['plugins']) !== false && ! empty($dir)) {
                rename($dir[0], WP_PLUGIN_DIR . '/simplepay-gateway');
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
