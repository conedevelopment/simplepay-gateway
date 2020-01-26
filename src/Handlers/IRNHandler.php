<?php

namespace Pine\SimplePay\Handlers;

use Pine\SimplePay\Requests\StatusRequest;
use Pine\SimplePay\Support\Log;

class IRNHandler extends Handler
{
    /**
     * Handle the IRN request.
     *
     * @param  array  $payload
     * @return void
     */
    public function handle($payload)
    {
        Log::info(__('IRN event was fired.', 'pine-simplepay'));

        $request = new StatusRequest($payload['transactionId']);
        $response = $request->post();

        if (! $request->valid()) {
            return;
        }

        $payload = json_decode($response['body'], true);
        $amount = (float) $this->order->get_remaining_refund_amount()
            - (float) $payload['transactions'][0]['remainingTotal'];

        if ($amount > 0) {
            wc_create_refund([
                'amount' => $amount,
                'order_id' => $this->order->get_id(),
            ]);
        }
    }
}
