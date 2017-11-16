<?php

namespace Pine\SimplePay\Requests;

use WC_Order;
use Pine\SimplePay\Support\Str;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Payloads\Transaction;

class RefundRequest extends Request
{
    /**
     * Initialize a new IRN request instance.
     *
     * @param  \WC_Order  $order
     * @param  int  $amount
     * @return void
     */
    public function __construct(WC_Order $order, $amount)
    {
        $this->url = Config::get('BASE_URL').Config::get('IRN_URL');

        $this->setPayload($order, $amount);
    }

    /**
     * Set the payload.
     *
     * @param  \WC_Order  $order
     * @param  int  $amount
     * @return void
     */
    protected function setPayload($order, $amount)
    {
        $this->payload = Transaction::handle($order, $amount);

        $this->calculateHash();
    }

    /**
     * Calculate the hash.
     *
     * @return void
     */
    protected function calculateHash()
    {
        $data = array_map(function ($item) {
            return Str::length($item);
        }, $this->payload);

        $this->payload['ORDER_HASH'] = Str::hash(implode('', $data));
    }

    /**
     * Validate the request.
     *
     * @return bool
     */
    public function validate()
    {
        if (preg_match_all("/<EPAYMENT>(.*?)<\/EPAYMENT>/", $this->response['body'], $matches) === 0) {
            return false;
        }

        return explode('|', $matches[1][0])[2] === 'OK';
    }
}
