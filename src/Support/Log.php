<?php

namespace Pine\SimplePay\Support;

class Log
{
    /**
     * The log context.
     *
     * @var array
     */
    protected static $context = [
        'source' => 'simplepay-gateway',
    ];

    /**
     * Log an "info" level event.
     *
     * @param  mixed  $data
     * @return void
     */
    public static function info($data)
    {
        if (Config::get('DEBUG')) {
            wc_get_logger()->info($data, static::$context);
        }
    }

    /**
     * Log a "debug" level event.
     *
     * @param  mixed  $data
     * @return void
     */
    public static function debug($data)
    {
        if (Config::get('DEBUG')) {
            wc_get_logger()->debug($data, static::$context);
        }
    }

    /**
     * Log an "error" level event.
     *
     * @param  mixed  $data
     * @return void
     */
    public static function error($data)
    {
        if (Config::get('DEBUG')) {
            wc_get_logger()->error($data, static::$context);
        }
    }
}
