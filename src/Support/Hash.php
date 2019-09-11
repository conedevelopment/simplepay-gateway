<?php

namespace Pine\SimplePay\Support;

class Hash
{
    /**
     * Make a hash version of the data.
     *
     * @param  string|array  $data
     * @return string
     */
    public static function make($data)
    {
        $data = implode('', array_map(function ($item) {
            return implode('', array_map(function ($value) {
                return strlen($value).$value;
            }, (array) $item));
        }, (array) $data));

        return hash_hmac('md5', $data, Config::get('SECRET_KEY'));
    }
}
