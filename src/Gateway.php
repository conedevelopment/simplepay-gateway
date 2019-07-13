<?php

namespace Pine\SimplePay;

use WC_Payment_Gateway;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Handlers\IPNHandler;
use Pine\SimplePay\Handlers\IRNHandler;
use Pine\SimplePay\Requests\RefundRequest;
use Pine\SimplePay\Requests\PaymentRequest;
use Pine\SimplePay\Handlers\PaymentHandler;

class Gateway extends WC_Payment_Gateway
{
    /**
     * The ID.
     *
     * @var string
     */
    public $id = 'simplepay-gateway';

    /**
     * The title.
     *
     * @var string
     */
    public $method_title = 'SimplePay';

    /**
     * The description.
     *
     * @var string
     */
    public $method_description = 'SimplePay payment gateway.';

    /**
     * The supported features.
     *
     * @var array
     */
    public $supports = [
        'refunds',
        'products',
    ];

    /**
     * The supported currencies.
     *
     * @var array
     */
    protected $currencies = [
        'HUF', 'USD', 'EUR',
    ];

    /**
     * Create a new gateway instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->init_settings();
        $this->init_form_fields();
        $this->setOptions();
        $this->checkCurrency();
    }

    /**
     * Register the gateway.
     *
     * @param  array  $gateways
     * @return array
     */
    public function register($gateways)
    {
        $gateways[] = __CLASS__;

        return $gateways;
    }

    /**
     * Check if the currency is supported by the gateway.
     *
     * @return void
     */
    public function checkCurrency()
    {
        if (! in_array(get_woocommerce_currency(), $this->currencies)) {
            $this->enabled = 'no';
        }
    }

    /**
     * Initialize the form fields.
     *
     * @return void
     */
    public function init_form_fields()
    {
        $this->form_fields = (include __DIR__ . '/../includes/fields.php');
    }

    /**
     * Set the options as gateway properties.
     *
     * @return void
     */
    protected function setOptions()
    {
        foreach (Config::settings() as $key => $option) {
            $this->{$key} = $option;
        }
    }

    /**
     * Process the payment.
     *
     * @param  string  $orderId
     * @return array
     */
    public function process_payment($orderId)
    {
        WC()->session->set('simplepay_token', $key = md5($orderId.time()));

        return [
            'result' => 'success',
            'redirect' => wc_get_order($orderId)->get_checkout_payment_url() . "&simplepay_token={$key}",
        ];
    }

    /**
     * Handle the payment.
     *
     * @param  int  $orderId
     * @return void
     */
    public function handlePayment($orderId)
    {
        $order = wc_get_order($orderId);

        Config::setByCurrency($order->get_currency());

        (new PaymentHandler($order))->handle();

        WC()->session->set('simplepay_token', null);
    }

    /**
     * Handle the IPN / IRN call.
     *
     * @return void
     */
    public function handleNotification()
    {
        Config::setByCurrency($_POST['CURRENCY']);

        if (in_array($_POST['ORDERSTATUS'], ['COMPLETE', 'PAYMENT_RECEIVED', 'PAYMENT_AUTHORIZED'])) {
            (new IPNHandler)->handle();
        } elseif ($_POST['ORDERSTATUS'] === 'REFUND') {
            (new IRNHandler)->handle();
        }
    }

    /**
     * Process the refund.
     *
     * @param  int  $orderId
     * @param  int|null  $amount
     * @param  string|null  $reason
     * @return bool
     */
    public function process_refund($orderId, $amount = null, $reason = '')
    {
        $order = wc_get_order($orderId);

        Config::setByCurrency($order->get_currency());

        if ($order && $order->get_transaction_id()) {
            $request = new RefundRequest($order, $amount);

            return $request->post() && $request->validate();
        }

        return false;
    }

    /**
     * Get the transaction URL.
     *
     * @param  \WC_Order  $order
     * @return string
     */
    public function get_transaction_url($order)
    {
        if ($this->sandbox === 'yes') {
            $this->view_transaction_url = 'https://sandbox.simplepay.hu/admin/transactions/data/%s';
        } else {
            $this->view_transaction_url = 'https://secure.simplepay.hu/admin/transactions/data/%s';
        }

        return parent::get_transaction_url($order);
    }

    /**
     * Determine if the user can pay.
     *
     * @return bool
     */
    protected function canPay()
    {
        return $_GET['pay_for_order'] === 'true'
            && isset($_GET['simplepay_token'])
            && $_GET['simplepay_token'] === WC()->session->get('simplepay_token')
            && isset($_GET['key']);
    }

    /**
     * Append the form to the footer.
     *
     * @return void
     */
    public function form()
    {
        if (($order = wc_get_order(get_query_var('order-pay'))) && $order->needs_payment() && $this->canPay()) {
            Config::setByCurrency($order->get_currency());

            $payment = new PaymentRequest($order);

            include_once __DIR__ . '/../includes/form.php';
        }
    }

    /**
     * Register the scripts and styles.
     *
     * @return void
     */
    public function scripts()
    {
        if ($this->canPay()) {
            wp_enqueue_style("{$this->id}-form", plugin_dir_url(__DIR__) . 'css/form.css', []);
        }
    }

    /**
     * Format the given URL.
     *
     * @param  string  $url
     * @param  \WC_Order  $order
     * @return string
     */
    public function formatUrl($url, $order)
    {
        return str_replace('/?', '?', $url);
    }

    /**
     * Register the hooks.
     *
     * @return void
     */
    public function registerHooks()
    {
        add_action('wp_footer', [$this, 'form']);
        add_action('wp_enqueue_scripts', [$this, 'scripts']);
        add_filter('woocommerce_payment_gateways', [$this, 'register']);
        add_filter("woocommerce_thankyou_{$this->id}", [$this, 'handlePayment']);
        add_action("woocommerce_api_wc_gateway_{$this->id}", [$this, 'handleNotification']);
        add_filter('woocommerce_get_checkout_order_received_url', [$this, 'formatUrl'], 10, 2);
        add_action("woocommerce_update_options_payment_gateways_{$this->id}", [$this, 'process_admin_options']);
    }
}
