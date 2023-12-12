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

        switch ($payload['status']) {
            case 'FINISHED';
                $this->handleFinished();
                break;
            case 'NOTAUTHORIZED';
                $this->handleNotAuthorized();
                break;
            case 'CANCELLED';
                $this->handleCancelled();
                break;
            case 'TIMEOUT';
                $this->handleTimeout();
                break;
            default:
                Log::error(sprintf(
                    '%s %s',
                    __('Unknown IPN status:', 'cone-simplepay'),
                    $payload['status']
                ));
                break;
        };
    }

    /**
     * Handle the FINISHED event.
     *
     * @return void
     */
    protected function handleFinished()
    {
        $this->order->payment_complete();

        $virtual = true;

        foreach ($this->order->get_items(['line_item']) as $item) {
            if (! $virtual = $item->get_product()->is_virtual()) {
                break;
            }
        }

        if ($virtual) {
            $this->order->update_status('completed');
        }
    }

    /**
     * Handle the NOTAUTHORIZED event.
     *
     * @return void
     */
    protected function handleNotAuthorized()
    {
        $this->order->update_status('failed');
    }

    /**
     * Handle the CANCELLED event.
     *
     * @return void
     */
    protected function handleCancelled()
    {
        $this->order->update_status('pending');
    }

    /**
     * Handle the TIMEOUT event.
     *
     * @return void
     */
    protected function handleTimeout()
    {
        $this->order->update_status('cancelled');
    }
}
