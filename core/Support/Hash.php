<?php

namespace Pine\SimplePay\Support;

abstract class Hash
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
            return is_array($item)
                ? implode('', array_map(function ($value) {
                    return strlen($value).$value;
                }, $item))
                : strlen($item).$item;
        }, (array) $data));

        return hash_hmac('md5', $data, Config::get('SECRET_KEY'));
    }
}
