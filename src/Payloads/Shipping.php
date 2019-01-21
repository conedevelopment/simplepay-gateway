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
     * @return void
     */
    protected static function serialize(WC_Order $order)
    {
        self::$data['DELIVERY_CITY'] = $order->get_shipping_city();
        self::$data['DELIVERY_PHONE'] = $order->get_billing_phone();
        self::$data['DELIVERY_EMAIL'] = $order->get_billing_email();
        self::$data['DELIVERY_STATE'] = $order->get_shipping_state();
        self::$data['DELIVERY_LNAME'] = $order->get_shipping_last_name();
        self::$data['DELIVERY_ZIPCODE'] = $order->get_shipping_postcode();
        self::$data['DELIVERY_FNAME'] = $order->get_shipping_first_name();
        self::$data['DELIVERY_ADDRESS'] = $order->get_shipping_address_1();
        self::$data['DELIVERY_ADDRESS2'] = $order->get_shipping_address_2();
        self::$data['DELIVERY_COUNTRYCODE'] = $order->get_shipping_country();
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
