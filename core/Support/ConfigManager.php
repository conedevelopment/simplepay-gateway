<?php

namespace Pine\SimplePay\Support;

class ConfigManager
{
    /**
     * The options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The gateway settings.
     *
     * @var array
     */
    protected $settings = [];

    /**
     * Initialize a new config manager instance.
     *
     * @param  array  $settings
     * @return void
     */
    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
        $this->options = (include pine_path('includes/config.php'));

        $this->configure();
    }

    /**
     * Get a config value by its key.
     *
     * @param  string  $key
     * @return array
     */
    public function get($key = null)
    {
        if (is_null($key)) {
            return $this->options;
        }

        return $this->options[$key];
    }

    /**
     * Set a config value of the given key.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function set($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * Configure the settings.
     *
     * @return void
     */
    protected function configure()
    {
        $this->set('LICENSE_KEY', $this->settings['license_key']);
        $this->set('SANDBOX', $this->settings['sandbox'] === 'yes' ? true : false);
        $this->set('BASE_URL',
            $this->get('SANDBOX') ? $this->get('SANDBOX_URL') : $this->get('LIVE_URL')
        );
    }

    /**
     * Set the secret key and merchant by the currency.
     *
     * @param  string  $currency
     * @return voud
     */
    public function setByCurrency($currency)
    {
        $this->set('MERCHANT', $this->settings[strtolower($currency)."_merchant"]);
        $this->set('SECRET_KEY', $this->settings[strtolower($currency)."_secret_key"]);
    }
}
