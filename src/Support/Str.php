<?php

namespace Pine\SimplePay\Support;

abstract class Str
{
    /**
     * Make the order reference using the given ID.
     *
     * @param  int  $id
     * @return string
     */
    public static function refFromId($id)
    {
        return sprintf('%s%s', Config::get('prefix'), $id);
    }

    /**
     * Get the ID from the given order reference.
     *
     * @param  string  $ref
     * @return string
     */
    public static function idFromRef($ref)
    {
        return str_replace(Config::get('prefix'), '', $ref);
    }
}
