<?php

namespace Pine\SimplePay\Payloads;

use WC_Order;

abstract class Order
{
    /**
     * The data.
     *
     * @var array
     */
    protected static $data = [
        'ORDER_PNAME' => [],
        'ORDER_PCODE' => [],
        'ORDER_PINFO' => [],
        'ORDER_PRICE' => [],
        'ORDER_QTY' => [],
        'ORDER_VAT' => [],
    ];

    /**
     * Serialize the data.
     *
     * @param  \WC_Order  $order
     * @return void
     */
    protected static function serialize(WC_Order $order)
    {
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();

            self::$data['ORDER_QTY'][] = $item->get_quantity();
            self::$data['ORDER_PNAME'][] = $product->get_name();
            self::$data['ORDER_PINFO'][] = $product->get_description();
            self::$data['ORDER_PRICE'][] = ($item->get_total() + $item->get_total_tax()) / $item->get_quantity();
            self::$data['ORDER_VAT'][] = 0;
            self::$data['ORDER_PCODE'][] = $product->get_sku() ?: $product->get_id();
        }
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
