<?php

namespace Pine\SimplePay\Payloads;

use Pine\SimplePay\Plugin;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Support\Hash;
use Pine\SimplePay\Support\Str;
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
            'orderRef' => Str::refFromId($order->get_order_number()),
            'discount' => 0,
            'currency' => $order->get_currency(),
            'shippingCost' => $order->get_shipping_total() + $order->get_shipping_tax(),
            'language' => substr(get_bloginfo('language'), 0, 2),
            'url' => add_query_arg(['wc-api' => 'process_simplepay_payment'], home_url('/')),
            'sdkVersion' => 'Pine SimplePay Gateway:'.Plugin::VERSION,
            'total' => $order->get_total(),
            'customer' => $order->get_formatted_billing_full_name(),
            'customerEmail' => $order->get_billing_email(),
            'invoice' => static::invoice($order),
            'delivery' => static::delivery($order),
            'items' => static::items($order),
            'twoStep' => false,
            'maySelectInvoice' => false,
        ];
    }

    /**
     * Serialize the invoice.
     *
     * @param  \WC_Order  $order
     * @return array|null
     */
    protected static function invoice(WC_Order $order)
    {
        $credentials =  [
            'city' => $order->get_billing_city(),
            'phone' => $order->get_billing_phone(),
            'state' => $order->get_billing_state(),
            'zip' => $order->get_billing_postcode(),
            'company' => $order->get_billing_company(),
            'country' => $order->get_billing_country(),
            'address' => $order->get_billing_address_1(),
            'address2' => $order->get_billing_address_2(),
            'name' => $name = $order->get_formatted_billing_full_name(),
        ];

        return ! empty(array_diff(array_filter($credentials), compact('name'))) ? $credentials : null;
    }

    /**
     * Serialize the delivery.
     *
     * @param  \WC_Order  $order
     * @return array|null
     */
    protected static function delivery(WC_Order $order)
    {
        if (! $order->needs_shipping_address()) {
            return null;
        }

        return [
            'city' => $order->get_shipping_city(),
            'phone' => $order->get_billing_phone(),
            'state' => $order->get_shipping_state(),
            'zip' => $order->get_shipping_postcode(),
            'company' => $order->get_shipping_company(),
            'country' => $order->get_shipping_country(),
            'address' => $order->get_shipping_address_1(),
            'address2' => $order->get_shipping_address_2(),
            'name' => $order->get_formatted_shipping_full_name(),
        ];
    }

    /**
     * Serialize the items.
     *
     * @param  \WC_Order  $order
     * @return array
     */
    protected static function items(WC_Order $order)
    {
        return array_reduce($order->get_items(), function ($items, $item) {
            $product = $item->get_product();
            $quantity = ceil($item->get_quantity());
            $price = ($item->get_total() + $item->get_total_tax()) / $quantity;

            if ($price > 0) {
                $items[] = [
                    'tax' => 0,
                    'price' => $price,
                    'amount' => $quantity,
                    'title' => $product->get_name(),
                    'description' => $product->get_description(),
                    'ref' => $product->get_sku() ?: $product->get_id(),
                ];
            }

            return $items;
        }, []);
    }
}
