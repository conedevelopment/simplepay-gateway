<?php

namespace Cone\SimplePay\Payloads;

use Cone\SimplePay\Plugin;
use Cone\SimplePay\Support\Config;
use Cone\SimplePay\Support\Hash;
use Cone\SimplePay\Support\Str;
use DateTime;
use WC_Order;
use WC_Order_Item;
use WC_Order_Item_Coupon;
use WC_Order_Item_Fee;

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
            'timeout' => static::timeout($order),
            'methods' => ['CARD'],
            'merchant' => Config::get('merchant'),
            'orderRef' => Str::refFromId($order->get_order_number()),
            'discount' => static::discount($order),
            'currency' => $order->get_currency(),
            'shippingCost' => (float) $order->get_shipping_total() + (float) $order->get_shipping_tax(),
            'language' => substr(get_locale(), 0, 2),
            'url' => add_query_arg(['wc-api' => 'process_simplepay_payment'], home_url('/')),
            'sdkVersion' => 'Pine SimplePay Gateway:'.Plugin::VERSION,
            'total' => $order->get_total(),
            'customer' => $order->get_formatted_billing_full_name(),
            'customerEmail' => $order->get_billing_email(),
            'invoice' => static::invoice($order),
            'delivery' => static::delivery($order),
            'items' => static::items($order),
            'maySelectInvoice' => false,
            'twoStep' => static::shouldBeTwoStep($order),
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
     * Get the total discount of the order.
     *
     * @param  \WC_Order  $order
     * @return float
     */
    protected static function discount(WC_Order $order)
    {
        return array_reduce($order->get_items(['line_item', 'fee', 'coupon']), function ($total, $item) {
            if ($item instanceof WC_Order_Item_Coupon) {
                $total += $item->get_discount();
            } elseif ($item->get_total() < 0) {
                $total += abs($item->get_total() + $item->get_total_tax());
            }

            return $total;
        }, 0);
    }

    /**
     * Serialize the items.
     *
     * @param  \WC_Order  $order
     * @return array
     */
    protected static function items(WC_Order $order)
    {
        return array_reduce($order->get_items(['line_item', 'fee']), function ($items, $item) {
            if ($item instanceof WC_Order_Item_Fee) {
                if($item->get_total() > 0) {
                    $items[] = static::mapFeeItem($item);
                }
            } elseif ($item->get_subtotal() > 0) {
                $items[] = static::mapLineItem($item);
            }

            return $items;
        }, []);
    }

    /**
     * Map the order line item.
     *
     * @param  \WC_Order_Item  $item
     * @return array
     */
    protected static function mapLineItem(WC_Order_Item $item)
    {
        $product = $item->get_product();
        $quantity = ceil($item->get_quantity());

        return [
            'tax' => 0,
            'price' => abs($item->get_subtotal() + $item->get_total_tax()) / $quantity,
            'amount' => $quantity,
            'title' => wp_strip_all_tags($product->get_name(), true),
            'description' => wp_trim_words($product->get_description()),
            'ref' => $product->get_sku() ?: $product->get_id(),
        ];
    }

    /**
     * Map the order fee item.
     *
     * @param  \WC_Order_Item_Fee  $item
     * @return array
     */
    protected static function mapFeeItem(WC_Order_Item_Fee $item)
    {
        $quantity = ceil($item->get_quantity());

        return [
            'tax' => 0,
            'price' => abs($item->get_total() + $item->get_total_tax()) / $quantity,
            'amount' => $quantity,
            'title' => wp_strip_all_tags($item->get_name(), true),
            'description' => '',
            'ref' => $item->get_id(),
        ];
    }

    /**
     * Get the timeout.
     *
     * @param  \WC_Order  $order
     * @return string
     */
    public static function timeout(WC_Order $order): string
    {
        $time = new DateTime(apply_filters('cone_simplepay_payment_timeout', '+30 minutes'), wp_timezone());

        return $time->format('c');
    }

    /**
     * Determine if the payment should be two step.
     *
     * @param  \WC_Order  $order
     * @return bool
     */
    public static function shouldBeTwoStep(WC_Order $order)
    {
        return (bool) apply_filters('cone_simplepay_enable_two_step_payment', Config::isTwoStep(), $order);
    }
}
