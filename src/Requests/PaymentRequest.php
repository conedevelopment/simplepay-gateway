<?php

namespace Pine\SimplePay\Requests;

use Pine\SimplePay\Payloads\PaymentPayload;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Support\Hash;
use WC_Order;

class PaymentRequest extends Request
{
    /**
     * Create a new request instance.
     *
     * @param  \WC_Order  $order
     * @return void
     */
    public function __construct(WC_Order $order)
    {
        $this->url = Config::get('BASE_URL').'start';
        $this->body = PaymentPayload::handle($order);
        $this->headers['Signature'] = Hash::make($this->body);
    }
}
