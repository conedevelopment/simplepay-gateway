<?php

namespace Cone\SimplePay;

use Cone\SimplePay\Payloads\FinishPayload;
use Cone\SimplePay\Support\Config;
use Cone\SimplePay\Support\Log;
use Cone\SimplePay\Support\Request;
use Exception;
use WC_Order;

class TwoStepPayment
{
    /**
     * The action key.
     *
     * @var string
     */
    protected const ACTION = 'cone_simplepay_two_step_finish';

    /**
     * Register the hooks.
     *
     * @return void
     */
    public static function boot()
    {
        add_action('woocommerce_order_actions', [static::class, 'register']);
        add_action('woocommerce_order_action_'.static::ACTION, [static::class, 'handle']);
    }

    /**
     * Register the action.
     *
     * @param  array  $actions
     * @return array
     */
    public static function register($actions)
    {
        global $theorder;

        if (! $theorder->is_paid()
            && $theorder->get_meta('_cone_simplepay_two_step_payment_reserved')
            && ! $theorder->get_meta('_cone_simplepay_two_step_payment_finished')) {
            $actions[static::ACTION] = __('Finish the two step SimplePay payment', 'cone-simplepay');
        }

        return $actions;
    }

    /**
     * Perform the acion.
     *
     * @return void
     */
    public static function handle(WC_Order $order)
    {
        Config::setByCurrency($order->get_currency());

        $request = Request::post(
            Config::url('finish'),
            $payload = FinishPayload::handle($order)
        );

        try {
            $request->send();

            if (! $request->valid()) {
                throw new Exception(__('Request is invalid', 'cone-simplepay'));
            }

            $order->add_order_note(
                __('Two step SimplePay payment has been finished.', 'cone-simplepay')
            );
        } catch (Exception $e) {
            Log::info(sprintf('%s: %s', $e->getMessage(), $payload));

            $order->add_order_note(
                __('Two step SimplePay payment request has been failed.', 'cone-simplepay')
            );
        }
    }
}
