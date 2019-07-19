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
        /** @var \WC_Order_Item_Product $item */
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();

            static::$data['ORDER_QTY'][] = $item->get_quantity();
            static::$data['ORDER_PNAME'][] = $product->get_name();
            static::$data['ORDER_PINFO'][] = $product->get_description();
            static::$data['ORDER_PRICE'][] = ((float)$item->get_total() + (int)$item->get_total_tax()) / $item->get_quantity();
            static::$data['ORDER_VAT'][] = 0;
            static::$data['ORDER_PCODE'][] = $product->get_sku() ?: $product->get_id();
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
        static::serialize($order);

        return static::$data;
    }
}
