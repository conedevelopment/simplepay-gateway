<?php

namespace Pine\SimplePay\Support;

class Config
{
    /**
     * The config instance.
     *
     * @var \Pine\SimplePay\Support\ConfigManager
     */
    protected static $manager;

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

        static::$manager = new ConfigManager($settings);
    }

    /**
     * Get the settings.
     *
     * @return array
     */
    public static function settings()
    {
        return static::$settings;
    }

    /**
     * Call dinamically the config methods.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return static::$manager->{$method}(...$arguments);
    }
}
