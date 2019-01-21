<?php

namespace Pine\SimplePay;

use WP_Widget;

class Widget extends WP_Widget
{
    /**
     * Initialize a new widget instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('simplepay-logo', 'SimplePay Logo');
    }

    /**
     * The output of the widget.
     *
     * @return void
     */
    public function widget($args, $instance)
    {
		include simplepay_gateway_path('includes/widget.php');
    }
}
