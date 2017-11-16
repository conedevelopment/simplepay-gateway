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

        if (Config::get('LICENSE_KEY') !== null && version_compare(Config::get('VERSION'), ($data = $this->checkApi())->new_version, '<')) {
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
        $response = wp_remote_get('https://store.pineco.de/api/update/'.Config::get('LICENSE_KEY'));

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
        return $host === 'store.pineco.de' ? true : $allow;
    }

    /**
     * Check if the license key is missing.
     *
     * @return void
     */
    public function missingLicenseKey()
    {
        if (! Config::get('LICENSE_KEY')) {
            require_once pine_path('includes/missing-license-key.php');
        }
    }

    /**
     * Register the hooks.
     *
     * @return void
     */
    public function registerHooks()
    {
        add_filter('admin_notices', [$this, 'missingLicenseKey']);
        add_filter('pre_set_site_transient_update_plugins', [$this, 'check']);
        add_filter('http_request_host_is_external', [$this, 'allowApi'], 10, 3);
    }
}
