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
     * @return void
     */
    protected static function serialize(WC_Order $order)
    {
        self::$data['BILL_CITY'] = $order->get_billing_city();
        self::$data['BILL_PHONE'] = $order->get_billing_phone();
        self::$data['BILL_EMAIL'] = $order->get_billing_email();
        self::$data['BILL_STATE'] = $order->get_billing_state();
        self::$data['BILL_COMPANY'] = $order->get_billing_company();
        self::$data['BILL_LNAME'] = $order->get_billing_last_name();
        self::$data['BILL_ZIPCODE'] = $order->get_billing_postcode();
        self::$data['BILL_FNAME'] = $order->get_billing_first_name();
        self::$data['BILL_ADDRESS'] = $order->get_billing_address_1();
        self::$data['BILL_ADDRESS2'] = $order->get_billing_address_2();
        self::$data['BILL_COUNTRYCODE'] = $order->get_billing_country();
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
