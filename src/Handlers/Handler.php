<?php

namespace Cone\SimplePay\Handlers;

use WC_Order;

abstract class Handler
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
}
