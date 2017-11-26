<?php

namespace Pine\SimplePay\Requests;

use WC_Order;
use Pine\SimplePay\Support\Str;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Payloads\Order;
use Pine\SimplePay\Payloads\General;
use Pine\SimplePay\Payloads\Billing;
use Pine\SimplePay\Payloads\Shipping;

class PaymentRequest
{
    /**
     * The payload data.
     *
     * @var array
     */
    protected $payload = [];

    /**
     * The form url.
     *
     * @var string
     */
    protected $url;

    /**
     * The request payload data handlers.
     *
     * @var array
     */
    protected $handlers = [
        Order::class,
        General::class,
        Billing::class,
        Shipping::class,
    ];

    /**
     * The hashable datas.
     *
     * @var array
     */
    protected $hashables = [
        "MERCHANT",
        "ORDER_REF",
        "ORDER_DATE",
        "ORDER_PNAME",
        "ORDER_PCODE",
        "ORDER_PINFO",
        "ORDER_PRICE",
        "ORDER_QTY",
        "ORDER_VAT",
        "ORDER_SHIPPING",
        "PRICES_CURRENCY",
        "DISCOUNT",
        "PAY_METHOD",
    ];

    /**
     * Create a new request instance.
     *
     * @param  \WC_Order  $order
     * @return void
     */
    public function __construct(WC_Order $order)
    {
        $this->setPayload($order);

        $this->url = Config::get('BASE_URL').Config::get('LU_URL');
    }

    /**
     * Get the URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the payload.
     *
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Set the payload.
     *
     * @param  \WC_Order  $order
     * @return void
     */
    protected function setPayload(WC_Order $order)
    {
        foreach ($this->handlers as $handler) {
            $this->payload += $handler::handle($order);
        }

        $this->calculateHash();
    }

    /**
     * Calculate the hash.
     *
     * @return void
     */
    protected function calculateHash()
    {
        $data = array_map(function ($hashable) {
            if (is_array($item = $this->payload[$hashable])) {
                return array_map(function ($value) {
                    return Str::length(Str::clean($value));
                }, $item);
            }

            return [Str::length(Str::clean($item))];
        }, $this->hashables);

        $this->payload['ORDER_HASH'] = Str::hash(array_merge(...$data));
    }
}
