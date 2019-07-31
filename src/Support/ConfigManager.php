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

        return isset($this->options[$key]) ? $this->options[$key] : null;
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
        $this->set('DEBUG', ($this->settings['debug'] ?? null) === 'yes');
        $this->set('SANDBOX', ($this->settings['sandbox'] ?? null) === 'yes');

        $this->set('BASE_URL',
            $this->get('SANDBOX') ? 'https://sandbox.simplepay.hu/' : 'https://secure.simplepay.hu/'
        );
    }

    /**
     * Set the secret key and merchant by the currency.
     *
     * @param  string  $currency
     * @return void
     */
    public function setByCurrency($currency)
    {
        $currency = sprintf('%s%s', strtolower($currency), $this->get('SANDBOX') ? '_sandbox' : '');

        $this->set('MERCHANT', $this->settings["{$currency}_merchant"]);
        $this->set('SECRET_KEY', $this->settings["{$currency}_secret_key"]);
    }
}
