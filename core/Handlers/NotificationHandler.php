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
        $hash = $_POST['HASH'];
        unset($_POST['HASH']);

        return Hash::make($_POST) === $hash;
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

        $response = sprintf("<EPAYMENT>%s|%s</EPAYMENT>", $date, $data);

        Log::info(__('Event response: ', 'pine-simplepay').$response);

        return $response;
    }
}
