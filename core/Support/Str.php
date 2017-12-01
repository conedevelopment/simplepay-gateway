<?php

namespace Pine\SimplePay\Support;

abstract class Str
{
    /**
     * Make a hash version of the data.
     *
     * @param  string  $data
     * @return string
     */
    public static function hash($data)
    {
        $data = implode('', array_map(function ($item) {
            return is_array($item)
                ? implode('', array_map(function ($value) {
                    return static::length($value);
                }, $item))
                : static::length($item);
        }, (array) $data));

        return hash_hmac('md5', $data, Config::get('SECRET_KEY'));
    }

    /**
     * Calculate and prepend the number of bytes to the string.
     *
     * @param  string  $string
     * @return string
     */
    public static function length($string)
    {
        return strlen($string).$string;
    }
}
