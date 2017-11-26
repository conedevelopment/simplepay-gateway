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
        if (array($data)) {
            $data = implode('', $data);
        }

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
