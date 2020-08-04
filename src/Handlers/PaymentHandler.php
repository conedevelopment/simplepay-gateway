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
            $this->order->set_status('pending');
            $url = $this->order->get_checkout_order_received_url();
        } elseif ($payload['e'] === 'CANCEL') {
            $this->order->set_status('cancelled');
            wc_add_notice(__('You cancelled your transaction.', 'pine-simplepay'), 'error');
        } elseif ($payload['e'] === 'FAIL') {
            $this->order->set_status('failed');
            // phpcs:ignore Generic.Files.LineLength.TooLong
            $m = __('Failed SimplePay transaction: %d. Please check if your data is correct. If yes, please contact your card publisher.', 'pine-simplepay');
            wc_add_notice(sprintf($m, $payload['t']), 'error');
        } elseif ($payload['e'] === 'TIMEOUT') {
            $this->order->set_status('cancelled');
            wc_add_notice(__('The transaction has been expired!', 'pine-simplepay'), 'error');
        }

        $this->order->save();

        wp_safe_redirect($url);
        exit;
    }
}
