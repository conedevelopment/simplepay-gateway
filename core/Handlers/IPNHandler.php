<?php

namespace Pine\SimplePay\Handlers;

class IPNHandler extends NotificationHandler
{
    /**
     * Process the IPN request.
     * 
     * @return void
     */
    public function process()
    {
        if ($this->validate() && ($id = wc_get_order_id_by_order_key($_POST['REFNOEXT'])) !== 0) {
            wc_get_order($id)->payment_complete();

            die($this->confirm());
        }
    }
}
