<?php

namespace Pine\SimplePay\Payloads;

use WC_Order;
use Pine\SimplePay\Support\Config;

abstract class General
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
     * @return void
     */
    protected static function serialize(WC_Order $order)
    {
        self::$data['ORDER_TIMEOUT'] = 300;
        self::$data['PAY_METHOD'] = 'CCVISAMC';
        self::$data['MERCHANT'] = Config::get('MERCHANT');
        self::$data['ORDER_REF'] = $order->get_order_key();
        self::$data['DISCOUNT'] = 0;
        self::$data['PRICES_CURRENCY'] = $order->get_currency();
        self::$data['ORDER_SHIPPING'] = $order->get_shipping_total() + $order->get_shipping_tax();
        self::$data['TIMEOUT_URL'] = $order->get_checkout_payment_url();
        self::$data['BACK_REF'] = $order->get_checkout_order_received_url();
        self::$data['ORDER_DATE'] = $order->get_date_created()->date('Y-m-d H:i:s');
        self::$data['LANGUAGE'] = substr(get_bloginfo('language'), 0, 2);
    }

    /**
     * Handle the data.
     *
     * @param  \WC_Order  $order
     * @return array
     */
    public static function handle(WC_Order $order)
    {
        self::serialize($order);

        return self::$data;
    }
}
