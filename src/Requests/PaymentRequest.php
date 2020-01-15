<?php

namespace Pine\SimplePay\Requests;

use Pine\SimplePay\Payloads\Billing;
use Pine\SimplePay\Payloads\General;
use Pine\SimplePay\Payloads\Order;
use Pine\SimplePay\Payloads\Shipping;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Support\Hash;
use WC_Order;

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
        'MERCHANT',
        'ORDER_REF',
        'ORDER_DATE',
        'ORDER_PNAME',
        'ORDER_PCODE',
        'ORDER_PINFO',
        'ORDER_PRICE',
        'ORDER_QTY',
        'ORDER_VAT',
        'ORDER_SHIPPING',
        'PRICES_CURRENCY',
        'DISCOUNT',
        'PAY_METHOD',
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

        $this->setUrl();
    }

    /**
     * Set the URL.
     *
     * @return void
     */
    protected function setUrl()
    {
        $this->url = Config::get('BASE_URL').'payment/order/lu.php';
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

        $data = array_map(function ($hashable) {
            return $this->payload[$hashable];
        }, $this->hashables);

        $this->payload['ORDER_HASH'] = Hash::make($data);
    }
}
