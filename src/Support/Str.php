<?php

namespace Cone\SimplePay\Support;

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
        $prefix = Config::get('prefix') ?: 'wc-';

        $prefix = preg_replace('/(?:\-)+$/u', '', $prefix) . '-';

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
        $prefix = Config::get('prefix') ?: 'wc-';

        $ref = preg_replace('/^' . $prefix . '/', '', $ref);

        $position = strrpos($ref, '-');

        return $position === false ? $ref : substr($ref, $position + 1);
    }
}
