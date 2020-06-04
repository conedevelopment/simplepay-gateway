<?php

namespace Pine\SimplePay\Support;

abstract class Arr
{
    /**
     * Get the array value.
     *
     * @param  array  $array
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function get($array, $key, $default = null)
    {
        $key = strtok($key, '.');

        while ($key !== false) {
            $key = is_numeric($key) ? (int) $key : $key;

            if (! isset($array[$key])) {
                return $default;
            }

            $array = $array[$key];

            $key = strtok('.');
        }

        return $array;
    }
}
