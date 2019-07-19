<?php

namespace Pine\SimplePay\Handlers;

use WC_Order;
use Pine\SimplePay\Support\Hash;

class PaymentHandler
{
    /**
     * The order instance.
     *
     * @var \WC_Order
     */
    protected $order;

    /**
     * Initialize a new status request.
     *
     * @param  \WC_Order  $order
     * @return void
     */
    public function __construct(WC_Order $order)
    {
        $this->order = $order;
    }

    /**
     * Validate the response.
     *
     * @return bool
     */
    protected function validate()
    {
        if (! in_array($_GET['RC'], ['000', '001'])) {
            return false;
        }

        $url = substr($this->getUrl(), 0, -38);

        return isset($_GET['ctrl']) && $_GET['ctrl'] === Hash::make($url);
    }

    /**
     * Process the payment request.
     *
     * @return void
     */
    public function handle()
    {
        $url = wc_get_checkout_url();

        if ($this->validate()) {
            $this->order->set_transaction_id($_GET['payrefno']);
            $this->order->save();
            $url = $this->order->get_checkout_order_received_url();
        } else {
            wc_add_notice(__('Payment failed. Please try it again later.', 'pine-simplepay'), 'error');
        }

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
