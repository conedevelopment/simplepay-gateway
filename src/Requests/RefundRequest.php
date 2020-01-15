<?php

namespace Pine\SimplePay\Requests;

use Pine\SimplePay\Payloads\Transaction;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Support\Hash;
use WC_Order;

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
        $this->url = Config::get('BASE_URL').'payment/order/irn.php';

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

        $this->payload['ORDER_HASH'] = Hash::make($this->payload);
    }

    /**
     * Validate the request.
     *
     * @return bool
     */
    public function validate()
    {
        if (! preg_match('/<EPAYMENT>(.*?)<\/EPAYMENT>/', $this->response['body'], $match)) {
            return false;
        }

        return explode('|', $match[1])[2] === 'OK';
    }
}
