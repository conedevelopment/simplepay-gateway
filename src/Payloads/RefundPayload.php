<?php

namespace Pine\SimplePay\Payloads;

use Pine\SimplePay\Plugin;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Support\Hash;
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
            'orderRef' => $order->get_order_key(),
            'currency' => $order->get_order_currency(),
            'sdkVersion' => 'Pine SimplePay Gateway:'.Plugin::VERSION,
        ];
    }
}
