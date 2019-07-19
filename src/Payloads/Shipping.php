<?php

namespace Pine\SimplePay\Payloads;

use WC_Order;

abstract class Shipping
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
        static::$data['DELIVERY_CITY'] = $order->get_shipping_city();
        static::$data['DELIVERY_PHONE'] = $order->get_billing_phone();
        static::$data['DELIVERY_EMAIL'] = $order->get_billing_email();
        static::$data['DELIVERY_STATE'] = $order->get_shipping_state();
        static::$data['DELIVERY_LNAME'] = $order->get_shipping_last_name();
        static::$data['DELIVERY_ZIPCODE'] = $order->get_shipping_postcode();
        static::$data['DELIVERY_FNAME'] = $order->get_shipping_first_name();
        static::$data['DELIVERY_ADDRESS'] = $order->get_shipping_address_1();
        static::$data['DELIVERY_ADDRESS2'] = $order->get_shipping_address_2();
        static::$data['DELIVERY_COUNTRYCODE'] = $order->get_shipping_country();
    }

    /**
     * Handle the data.
     *
     * @param  \WC_Order  $order
     * @return array
     */
    public static function handle(WC_Order $order)
    {
        static::serialize($order);

        return static::$data;
    }
}
