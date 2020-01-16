<?php

namespace Pine\SimplePay\Handlers;

use Pine\SimplePay\Support\Log;

class IPNHandler extends Handler
{
    /**
     * Handle the IPN request.
     *
     * @param  array  $payload
     * @return void
     */
    public function handle($payload)
    {
        Log::info(__('IPN event was fired.', 'pine-simplepay'));

        $this->order->payment_complete();
    }
}
