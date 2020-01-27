<?php

namespace Pine\SimplePay\Payloads;

use Pine\SimplePay\Plugin;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Support\Hash;
use WC_Order;

abstract class PaymentPayload
{
    /**
     * Handle the data.
     *
     * @param  \WC_Order  $order
     * @return string
     */
    public static function handle(WC_Order $order)
    {
        return json_encode(static::serialize($order));
    }

    /**
     * Serialize the data.
     *
     * @param  \WC_Order  $order
     * @return array
     */
    protected static function serialize(WC_Order $order)
    {
        return [
            'salt' => Hash::salt(),
            'timeout' => date('c', strtotime('+30 minutes')),
            'methods' => ['CARD'],
            'merchant' => Config::get('merchant'),
            'orderRef' => $order->get_order_key(),
            'discount' => 0,
            'currency' => $order->get_currency(),
            'shippingCost' => $order->get_shipping_total() + $order->get_shipping_tax(),
            'language' => substr(get_bloginfo('language'), 0, 2),
            'url' => add_query_arg(['wc-api' => 'process_simplepay_payment'], site_url()),
            'sdkVersion' => 'Pine SimplePay Gateway:'.Plugin::VERSION,
            'total' => $order->get_total(),
            'customerEmail' => $order->get_billing_email(),
            'invoice' => static::invoice($order),
            'items' => static::items($order),
            'twoStep' => false,
            'maySelectInvoice' => false,
            'delivery' => static::delivery($order),
        ];
    }

    /**
     * Serialize the invoice.
     *
     * @param  \WC_Order  $order
     * @return array
     */
    protected static function invoice(WC_Order $order)
    {
        return [
            'city' => $order->get_billing_city(),
            'phone' => $order->get_billing_phone(),
            'state' => $order->get_billing_state(),
            'zip' => $order->get_billing_postcode(),
            'company' => $order->get_billing_company(),
            'country' => $order->get_billing_country(),
            'address' => $order->get_billing_address_1(),
            'address2' => $order->get_billing_address_2(),
            'name' => "{$order->get_billing_first_name()} {$order->get_billing_last_name()}",
        ];
    }

    /**
     * Serialize the delivery.
     *
     * @param  \WC_Order  $order
     * @return array
     */
    protected static function delivery(WC_Order $order)
    {
        return [
            'city' => $order->get_shipping_city(),
            'phone' => $order->get_billing_phone(),
            'state' => $order->get_shipping_state(),
            'zip' => $order->get_shipping_postcode(),
            'company' => $order->get_shipping_company(),
            'country' => $order->get_shipping_country(),
            'address' => $order->get_shipping_address_1(),
            'address2' => $order->get_shipping_address_2(),
            'name' => "{$order->get_shipping_first_name()} {$order->get_shipping_last_name()}",
        ];
    }

    /**
     * Serialize the item.
     *
     * @param  \WC_Order  $order
     * @return array
     */
    protected static function items(WC_Order $order)
    {
        return array_reduce($order->get_items(), function ($items, $item) {
            $product = $item->get_product();

            $items[] = [
                'tax' => 0,
                'title' => $product->get_name(),
                'amount' => $item->get_quantity(),
                'description' => $product->get_description(),
                'ref' => $product->get_sku() ?: $product->get_id(),
                'price' => ($item->get_total() + $item->get_total_tax()) / $item->get_quantity(),
            ];

            return $items;
        }, []);
    }
}
