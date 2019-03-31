<?php

namespace Pine\SimplePay\Handlers;

use Pine\SimplePay\Support\Log;
use Pine\SimplePay\Support\Hash;

abstract class NotificationHandler
{
    /**
     * Validate the IPN request.
     *
     * @return bool
     */
    protected function validate()
    {
        $hash = Hash::make(array_filter($_POST, function ($key) {
            return $key !== 'HASH';
        }, ARRAY_FILTER_USE_KEY));

        return $hash === $_POST['HASH'];
    }

    /**
     * Confirm the IPN request.
     *
     * @return string
     */
    protected function confirm()
    {
        $data = Hash::make([
            $_POST['IPN_PID'][0],
            $_POST['IPN_PNAME'][0],
            $_POST['IPN_DATE'],
            ($date = date('YmdHis')),
        ]);

        $response = sprintf('<EPAYMENT>%s|%s</EPAYMENT>', $date, $data);

        Log::info(__('Event response: ', 'pine-simplepay') . $response);

        return $response;
    }
}
