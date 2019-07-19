<?php

namespace Pine\SimplePay\Handlers;

use Pine\SimplePay\Support\Log;

class IRNHandler extends NotificationHandler
{
    /**
     * Handle the IRN request.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(__('IRN event was fired.', 'pine-simplepay'));

        if ($this->validate() && ($id = wc_get_order_id_by_order_key($_POST['REFNOEXT'])) !== 0) {
            $order = wc_get_order($id);

            if (($amount = abs($_POST['IPN_TOTALGENERAL']) - (float)$order->get_total_refunded()) > 0) {
                if ($amount <= $order->get_remaining_refund_amount()) {
                    wc_create_refund([
                        'order_id' => $id,
                        'amount' => $amount,
                    ]);
                }
            }

            die($this->confirm());
        }
    }
}
