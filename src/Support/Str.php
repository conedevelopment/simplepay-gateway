<?php

namespace Pine\SimplePay\Support;

abstract class Str
{
    /**
     * Make the order reference using the given ID.
     *
     * @param  string  $id
     * @return string
     */
    public static function refFromId($id)
    {
        $prefix = Config::has('prefix') ? Config::get('prefix') : 'wc-';

        return sprintf('%s%s', $prefix, $id);
    }

    /**
     * Get the ID from the given order reference.
     *
     * @param  string  $ref
     * @return string
     */
    public static function idFromRef($ref)
    {
        $prefix = Config::has('prefix') ? Config::get('prefix') : 'wc-';

        return str_replace($prefix, '', $ref);
    }
}
