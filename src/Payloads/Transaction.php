<?php

namespace Pine\SimplePay\Payloads;

use Pine\SimplePay\Support\Config;
use WC_Order;

abstract class Transaction
{
    /**
     * The data.
     *
     * @var array
     */
    protected static $data = [];

    /**
     * Serialize the data.
     *
     * @param  \WC_Order  $order
     * @param  int|float  $amount
     * @return void
     */
    protected static function serialize(WC_Order $order, $amount)
    {
        static::$data['MERCHANT'] = Config::get('MERCHANT');
        static::$data['ORDER_REF'] = $order->get_transaction_id();
        static::$data['ORDER_AMOUNT'] = $order->get_total();
        static::$data['ORDER_CURRENCY'] = $order->get_order_currency();
        static::$data['IRN_DATE'] = date('Y-m-d H:i:s');
        static::$data['AMOUNT'] = $amount;
    }

    /**
     * Handle the data.
     *
     * @param  \WC_Order  $order
     * @param  int|float  $amount
     * @return array
     */
    public static function handle(WC_Order $order, $amount)
    {
        static::serialize($order, $amount);

        return static::$data;
    }
}
