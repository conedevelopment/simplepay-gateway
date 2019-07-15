<?php

namespace Pine\SimplePay;

class Updater
{
    /**
     * The repo URL.
     *
     * @var string
     */
    protected $url = 'https://raw.githubusercontent.com/thepinecode/simplepay-gateway/master/updater/%s.json';

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
        } elseif (! $response = get_transient('simplepay_info_' . Plugin::SLUG)) {
            $response = wp_remote_get(sprintf($this->url, 'info'));

            if (wp_remote_retrieve_response_code($response) == 200 && wp_remote_retrieve_body($response)) {
                set_transient('simplepay_info_' . Plugin::SLUG, $response, 43200);
            }
        }

        if ($response) {
            return json_decode(wp_remote_retrieve_body($response));
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
            $response = wp_remote_get(sprintf($this->url, 'info'));

            if (wp_remote_retrieve_response_code($response) == 200 && wp_remote_retrieve_body($response)) {
                set_transient('simplepay_update_' . Plugin::SLUG, $response, 43200);
            }
        }

        if ($response) {
            $response = json_decode(wp_remote_retrieve_body($response));

            if (version_compare(Plugin::VERSION, $response->new_version, '<')) {
                $transient->response[Plugin::SLUG] = $response;
                $transient->checked[Plugin::SLUG] = $response->new_version;
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
            delete_transient('simplepay_info_' . Plugin::SLUG);
            delete_transient('simplepay_update_' . Plugin::SLUG);
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
