<?php

namespace Pine\SimplePay\Requests;

use Pine\SimplePay\Payloads\RefundPayload;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Support\Hash;
use WC_Order;

class RefundRequest extends Request
{
    /**
     * Initialize a new request instance.
     *
     * @param  \WC_Order  $order
     * @param  int|float  $amount
     * @return void
     */
    public function __construct(WC_Order $order, $amount)
    {
        $this->url = Config::get('BASE_URL').'refund';
        $this->body = RefundPayload::handle($order, $amount);
        $this->headers['Signature'] = Hash::make($this->body);
    }
}
