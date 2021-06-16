<?php

namespace Cone\SimplePay\Handlers;

use Cone\SimplePay\Support\Log;

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
        Log::info(sprintf(
            "%s\n%s",
            __('IPN event was fired.', 'cone-simplepay'),
            json_encode($payload)
        ));

        $this->order->payment_complete();
    }
}
