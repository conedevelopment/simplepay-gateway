<?php

namespace Pine\SimplePay\Support;

abstract class Config
{
    /**
     * The API url.
     *
     * @var string
     */
    protected static $url = 'https://%s.simplepay.hu/payment/v2/%s';

    /**
     * The database settings.
     *
     * @var array
     */
    protected static $settings = [];

    /**
     * Set the confing manager.
     *
     * @param  array  $settings
     * @return void
     */
    public static function boot(array $settings = [])
    {
        static::$settings = $settings;
    }

    /**
     * Get a config value by its key.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return static::$settings;
        }

        return isset(static::$settings[$key]) ? static::$settings[$key] : $default;
    }

    /**
     * Set a config value of the given key.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public static function set($key, $value)
    {
        static::$settings[$key] = $value;
    }

    /**
     * Set the secret key and merchant by the currency.
     *
     * @param  string  $currency
     * @return void
     */
    public static function setByCurrency($currency)
    {
        $currency = sprintf('%s%s', strtolower($currency), static::isSandbox() ? '_sandbox' : '');

        static::set('merchant', static::get("{$currency}_merchant"));
        static::set('secret_key', static::get("{$currency}_secret_key"));
    }

    /**
     * Get the url.
     *
     * @param  string|null  $path
     * @return string
     */
    public static function url($path = null)
    {
        return sprintf(static::$url, static::isSandbox() ? 'sandbox' : 'secure', $path);
    }

    /**
     * Determine if the environment is sandbox.
     *
     * @return bool
     */
    public static function isSandbox()
    {
        return static::get('sandbox') === 'yes';
    }

    /**
     * Determine if the debugging is enabled.
     *
     * @return bool
     */
    public static function isDebug()
    {
        return static::get('debug') === 'yes';
    }
}
