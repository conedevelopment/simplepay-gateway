<?php

namespace Pine\SimplePay\Handlers;

use Pine\SimplePay\Support\Log;

class IPNHandler extends NotificationHandler
{
    /**
     * Handle the IPN request.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(__('IPN event was fired.', 'pine-simplepay'));

        if ($this->validate() && ($id = wc_get_order_id_by_order_key($_POST['REFNOEXT'])) !== 0) {
            wc_get_order($id)->payment_complete();

            die($this->confirm());
        }
    }
}
