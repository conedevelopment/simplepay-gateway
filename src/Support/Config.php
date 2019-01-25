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
        self::$settings = $settings;
        self::$manager = new ConfigManager($settings);
    }

    /**
     * Get the settings.
     *
     * @return array
     */
    public static function settings()
    {
        return self::$settings;
    }

    /**
     * Call dinamically the config methods.
     *
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return self::$manager->{$method}(...$arguments);
    }
}
