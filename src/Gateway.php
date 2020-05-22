<?php

namespace Pine\SimplePay;

use Pine\SimplePay\Handlers\IPNHandler;
use Pine\SimplePay\Handlers\IRNHandler;
use Pine\SimplePay\Handlers\PaymentHandler;
use Pine\SimplePay\Requests\PaymentRequest;
use Pine\SimplePay\Requests\RefundRequest;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Support\Hash;
use WC_Order;
use WC_Payment_Gateway;

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
    public $method_description = 'SimplePay payment gateway';

    /**
     * The supported features.
     *
     * @var array
     */
    public $supports = [
        'refunds', 'products',
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
        $this->form_fields = (include __DIR__.'/../includes/fields.php');
    }

    /**
     * Set the options as gateway properties.
     *
     * @return void
     */
    protected function setOptions()
    {
        foreach (Config::get() as $key => $option) {
            $this->{$key} = $option;
        }
    }

    /**
     * Process the payment.
     *
     * @param  int  $orderId
     * @return array
     */
    public function process_payment($orderId)
    {
        $order = wc_get_order($orderId);

        Config::setByCurrency($order->get_currency());

        $request = new PaymentRequest($order);
        $response = $request->post();

        return [
            'result' => $request->valid() ? 'success' : 'error',
            'redirect' => json_decode($response['body'])->paymentUrl,
        ];
    }

    /**
     * Handle the payment.
     *
     * @return void
     */
    public function handlePayment()
    {
        $payload = json_decode(base64_decode($_GET['r']), true);

        if (! $order = wc_get_order(wc_get_order_id_by_order_key(strtolower($payload['o'])))) {
            wp_safe_redirect(wc_get_checkout_url());
            exit;
        }

        Config::setByCurrency($order->get_currency());

        (new PaymentHandler($order))->handle($payload);
    }

    /**
     * Handle the IPN / IRN call.
     *
     * @return void
     */
    public function handleNotification()
    {
        $input = file_get_contents('php://input');
        $payload = json_decode($input, true);
        $order = wc_get_order(wc_get_order_id_by_order_key($payload['orderRef']));

        if (! $order instanceof WC_Order) {
            die(__('Order not found.', 'pine-simplepay'));
        }

        Config::setByCurrency($order->get_currency());

        if (! Hash::check($_SERVER['HTTP_SIGNATURE'], $input)) {
            die(__('Invalid signature.', 'pine-simplepay'));
        }

        if (isset($payload['refundStatus']) && $payload['status'] === 'FINISHED') {
            (new IRNHandler($order))->handle($payload);
        } elseif ($payload['status'] === 'FINISHED') {
            (new IPNHandler($order))->handle($payload);
        }

        $payload['receiveDate'] = date('c');
        header('Content-type: application/json');
        header('Signature: '.Hash::make($response = json_encode($payload)));
        die($response);
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

        if ($order && $order->get_transaction_id()) {
            Config::setByCurrency($order->get_currency());

            $request = new RefundRequest($order, $amount);
            $request->post();

            return $request->valid();
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
        if (Config::isSandbox()) {
            $this->view_transaction_url = 'https://sandbox.simplepay.hu/admin/transactions/data/%s';
        } else {
            $this->view_transaction_url = 'https://secure.simplepay.hu/admin/transactions/data/%s';
        }

        return parent::get_transaction_url($order);
    }

    /**
     * Extend the order table with the transaction ID.
     *
     * @param  \WC_Order  $order
     * @return void
     */
    public function extnendOrderTable($order)
    {
        include __DIR__.'/../includes/order-item-row.php';
    }

    /**
     * Register the admin scripts.
     *
     * @param  string  $hook
     * @return void
     */
    public function scripts($hook)
    {
        if ($hook === 'woocommerce_page_wc-settings' && $_GET['section'] === 'simplepay-gateway') {
            wp_enqueue_script('simplepay', plugin_dir_url(__DIR__).'includes/simplepay.js');
        }
    }

    /**
     * Boot the gateway.
     *
     * @return void
     */
    public static function boot()
    {
        (new static)->registerHooks();
    }

    /**
     * Register the hooks.
     *
     * @return void
     */
    public function registerHooks()
    {
        add_action( 'admin_enqueue_scripts', [$this, 'scripts']);
        add_filter('woocommerce_payment_gateways', [$this, 'register']);
        add_filter('woocommerce_api_process_simplepay_payment', [$this, 'handlePayment']);
        add_action("woocommerce_api_wc_gateway_{$this->id}", [$this, 'handleNotification']);
        add_action('woocommerce_order_details_after_order_table_items', [$this, 'extnendOrderTable']);
        add_action("woocommerce_update_options_payment_gateways_{$this->id}", [$this, 'process_admin_options']);
    }
}
