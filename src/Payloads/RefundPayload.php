<?php

namespace Cone\SimplePay\Payloads;

use Cone\SimplePay\Plugin;
use Cone\SimplePay\Support\Config;
use Cone\SimplePay\Support\Hash;
use Cone\SimplePay\Support\Str;
use WC_Order;

abstract class RefundPayload
{
    /**
     * Handle the data.
     *
     * @param  \WC_Order  $order
     * @param  int|float  $amount
     * @return string
     */
    public static function handle(WC_Order $order, $amount)
    {
        return json_encode(static::serialize($order, $amount));
    }

    /**
     * Serialize the data.
     *
     * @param  \WC_Order  $order
     * @param  int|float  $amount
     * @return array
     */
    protected static function serialize(WC_Order $order, $amount)
    {
        return [
            'salt' => Hash::salt(),
            'refundTotal' => $amount,
            'merchant' => Config::get('merchant'),
            'currency' => $order->get_order_currency(),
            'orderRef' => Str::refFromId($order->get_order_number()),
            'sdkVersion' => 'Pine SimplePay Gateway:' . Plugin::VERSION,
        ];
    }
}
