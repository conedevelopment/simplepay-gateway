<?php

namespace Pine\SimplePay\Handlers;

use Pine\SimplePay\Support\Hash;
use Pine\SimplePay\Support\Log;

abstract class NotificationHandler
{
    /**
     * Validate the IPN request.
     *
     * @return bool
     */
    protected function validate()
    {
        $hashables = array_filter($_POST, function ($key) {
            return $key !== 'HASH';
        }, ARRAY_FILTER_USE_KEY);

        return Hash::make($hashables) === $_POST['HASH'];
    }

    /**
     * Confirm the IPN request.
     *
     * @return string
     */
    protected function confirm()
    {
        $hash = Hash::make([
            $_POST['IPN_PID'][0],
            $_POST['IPN_PNAME'][0],
            $_POST['IPN_DATE'],
            ($date = date('YmdHis')),
        ]);

        $response = sprintf('<EPAYMENT>%s|%s</EPAYMENT>', $date, $hash);

        Log::info(__('Event response: ', 'pine-simplepay').$response);

        return $response;
    }
}
