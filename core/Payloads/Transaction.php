<?php

namespace Pine\SimplePay\Payloads;

use WC_Order;
use Pine\SimplePay\Support\Config;

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
     * @param  int  $amount
     * @return void
     */
    protected static function serialize(WC_Order $order, $amount)
    {
        self::$data['MERCHANT'] = Config::get('MERCHANT');
        self::$data['ORDER_REF'] = $order->get_transaction_id();
        self::$data['ORDER_AMOUNT'] = $order->get_total();
        self::$data['ORDER_CURRENCY'] = $order->get_order_currency();
        self::$data['IRN_DATE'] = date('Y-m-d H:i:s');
        self::$data['AMOUNT'] = $amount;
    }

    /**
     * Handle the data.
     *
     * @param  \WC_Order  $order
     * @param  int  $amount
     * @return array
     */
    public static function handle(WC_Order $order, $amount)
    {
        self::serialize($order, $amount);

        return self::$data;
    }
}
