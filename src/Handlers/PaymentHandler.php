<?php

namespace Cone\SimplePay\Handlers;

use Cone\SimplePay\Payloads\PaymentPayload;
use Cone\SimplePay\Payloads\StatusPayload;
use Cone\SimplePay\Support\Config;
use Cone\SimplePay\Support\Request;
use Exception;

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
        $url = $this->order->get_checkout_payment_url();

        $this->order->set_transaction_id($payload['t']);

        if ($payload['e'] === 'SUCCESS') {
            if (! $this->order->is_paid()) {
                $this->order->set_status('pending');
            }

            if (PaymentPayload::shouldBeTwoStep($this->order)) {
                $this->handleTwoStepPayment();
            }

            $url = $this->order->get_checkout_order_received_url();
        } elseif ($payload['e'] === 'CANCEL') {
            $this->order->set_status('pending');

            wc_add_notice(sprintf(
                __('You cancelled your transaction: %d.', 'cone-simplepay'),
                $payload['t']
            ), 'error');
        } elseif ($payload['e'] === 'FAIL') {
            $this->order->set_status('failed');

            wc_add_notice(sprintf(
                __('Failed SimplePay transaction: %d. Please check if your data is correct. If yes, please contact your card publisher.', 'cone-simplepay'),
                $payload['t']
            ), 'error');
        } elseif ($payload['e'] === 'TIMEOUT') {
            $this->order->set_status('cancelled');

            wc_add_notice(sprintf(
                __('The transaction (%d) has been expired!', 'cone-simplepay')
                $payload['t']
            ), 'error');
        }

        $this->order->save();

        wp_safe_redirect($url);
        exit;
    }

    /**
     * Handle the two step payment.
     *
     * @return void
     */
    protected function handleTwoStepPayment()
    {
        Config::setByCurrency($this->order->get_currency());

        $request = Request::post(
            Config::url('query'),
            StatusPayload::handle($this->order->get_transaction_id())
        );

        try {
            $request->send();

            if ($request->valid()) {
                $total = (float) $request->body('transactions.0.total');

                $this->order->update_meta_data('_cone_simplepay_two_step_payment_reserved', $total);

                $this->order->add_order_note(sprintf(
                    __('%d %s is reserved in SimplePay.', 'cone-simplepay'),
                    $total,
                    $this->order->get_currency()
                ));
            }
        } catch (Exception $e) {
            $this->order->update_meta_data(
                '_cone_simplepay_two_step_payment_reserved',
                $total = $this->order->get_total()
            );

            $this->order->add_order_note(sprintf(
                __('%d %s is reserved in SimplePay (not precise).', 'cone-simplepay'),
                $total,
                $this->order->get_currency()
            ));
        }
    }
}
