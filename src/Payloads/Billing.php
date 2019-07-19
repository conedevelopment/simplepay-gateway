<?php

namespace Pine\SimplePay\Payloads;

use WC_Order;

abstract class Billing
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
        static::$data['BILL_CITY'] = $order->get_billing_city();
        static::$data['BILL_PHONE'] = $order->get_billing_phone();
        static::$data['BILL_EMAIL'] = $order->get_billing_email();
        static::$data['BILL_STATE'] = $order->get_billing_state();
        static::$data['BILL_COMPANY'] = $order->get_billing_company();
        static::$data['BILL_LNAME'] = $order->get_billing_last_name();
        static::$data['BILL_ZIPCODE'] = $order->get_billing_postcode();
        static::$data['BILL_FNAME'] = $order->get_billing_first_name();
        static::$data['BILL_ADDRESS'] = $order->get_billing_address_1();
        static::$data['BILL_ADDRESS2'] = $order->get_billing_address_2();
        static::$data['BILL_COUNTRYCODE'] = $order->get_billing_country();
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
