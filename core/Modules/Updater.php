<?php

namespace Pine\SimplePay\Modules;

use Pine\SimplePay\Support\Config;

class Updater
{
    /**
     * Check for update.
     *
     * @param  array  $transient
     * @return array
     */
    public function check($transient)
    {
        if (empty($transient->checked)) {
            return $transient;
        }

        $data = $this->checkApi();

        if (version_compare(Config::get('VERSION'), $data->new_version, '<')) {
            $transient->response['pine-simple-pay/pine-simple-pay.php'] = $data;
        }

        return $transient;
    }

    /**
     * Check the update info from the API.
     *
     * @return bool|object
     */
    protected function checkApi()
    {
        $response = wp_remote_get('https://pine-store.dev/api/update/'.Config::get('LICENSE_KEY'));

        return wp_remote_retrieve_response_code($response) === 200 ? json_decode($response['body']) : false;
    }

    /**
     * Allow the request on the API.
     *
     * @param  bool  $allow
     * @param  string  $host
     * @param  string  $url
     * @return bool
     */
    public function allowApi($allow, $host, $url)
    {
        if (in_array($host, ['pine-store.dev', 'store.pineco.de'])) {
            $allow = true;
        }

        return $allow;
    }

    /**
     * Register the hooks.
     *
     * @return void
     */
    public function registerHooks()
    {
        add_filter('https_ssl_verify', '__return_false');
        add_filter('https_local_ssl_verify', '__return_false');
        add_filter('pre_set_site_transient_update_plugins', [$this, 'check']);
        add_filter('http_request_host_is_external', [$this, 'allowApi'], 10, 3);
    }
}
