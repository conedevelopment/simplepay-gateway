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
        return hash_hmac('md5', $data, trim(Config::get('SECRET_KEY')));
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

    /**
     * Clean the string from the forbidden characters.
     * 
     * @param  string  $string
     * @return string
     */
    public static function clean($string)
    {
        return str_replace(["'", "\\", "\""], '', $string);
    }
}
