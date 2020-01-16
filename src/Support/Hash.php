<?php

namespace Pine\SimplePay\Support;

class Hash
{
    /**
     * Make a hash version of the data.
     *
     * @param  string  $data
     * @return string
     */
    public static function make($data)
    {
        return base64_encode(
            hash_hmac('sha384', $data, trim(Config::get('SECRET_KEY')), true)
        );
    }

    /**
     * Compare two hashes.
     *
     * @param  string  $hash
     * @param  string  $data
     * @return bool
     */
    public static function check($hash, $data)
    {
        return hash_equals($hash, static::make($data));
    }

    /**
     * Make a salt.
     *
     * @return string
     */
    public static function salt()
    {
        return substr(str_shuffle(md5(microtime())), 0, 32);
    }
}
