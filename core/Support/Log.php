<?php

namespace Pine\SimplePay\Support;

use WC_Logger;

abstract class Log
{
    /**
     * The log context.
     *
     * @var array
     */
    protected static $context = [
        'source' => 'pine-simple-pay',
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
            wc_get_logger()->info($data, self::$context);
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
            wc_get_logger()->debug($data, self::$context);
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
            wc_get_logger()->error($data, self::$context);
        }
    }
}
