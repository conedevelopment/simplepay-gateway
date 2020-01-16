<?php

namespace Pine\SimplePay\Handlers;

class PaymentHandler extends Handler
{
    /**
     * Process the payment request.
     *
     * @param  array  $payload
     * @return void
     */
    public function handle($payload)
    {
        $url = wc_get_checkout_url();

        $this->order->set_transaction_id($payload['t']);

        if ($payload['e'] === 'SUCCESS') {
            $url = $this->order->get_checkout_order_received_url();
        } elseif ($payload['e'] === 'CANCEL') {
            $this->order->set_status('cancelled');
            wc_add_notice(__('You cancelled you transaction.', 'pine-simplepay'), 'error');
        } elseif ($payload['e'] === 'FAIL') {
            $this->order->set_status('cancelled');
            wc_add_notice(sprintf(__('Failed trasnaction: %d. Please contact your card publisher.', 'pine-simplepay'), $payload['t']), 'error');
        } elseif ($payload['e'] === 'TIMEOUT') {
            $this->order->set_status('cancelled');
            wc_add_notice(__('The transaction has been expired!', 'pine-simplepay'), 'error');
        }

        $this->order->save();

        wp_safe_redirect($url);
        exit;
    }

    /**
     * Build the URL for hash calculating.
     *
     * @return string
     */
    protected function getUrl()
    {
        return str_replace('/?', '?', site_url($_SERVER['REQUEST_URI']));
    }
}
