<?php

namespace Pine\SimplePay\Handlers;

use Pine\SimplePay\Support\Log;
use Pine\SimplePay\Support\Str;

abstract class NotificationHandler
{
    /**
     * Validate the IPN request.
     *
     * @return bool
     */
    protected function validate()
    {
        $data = [];

        foreach ($_POST as $key => $value) {
            if ($key === 'HASH') {
                continue;
            }

            if (is_array($value)) {
                foreach ($value as $item) {
                    $data[] = Str::length($item);
                }
            } else {
                $data[] = Str::length($value);
            }
        }

        return Str::hash(implode('', $data)) === $_POST['HASH'];
    }

    /**
     * Confirm the IPN request.
     *
     * @return string
     */
    protected function confirm()
    {
        $data = array_map(function ($item) {
            return Str::length($item);
        }, [
            $_POST['IPN_PID'][0],
            $_POST['IPN_PNAME'][0],
            $_POST['IPN_DATE'],
            ($date = date('YmdHis')),
        ]);

        $response = sprintf("<EPAYMENT>%s|%s</EPAYMENT>", $date, Str::hash(implode('', $data)));

        Log::info(__('Event response: ', 'pine-simple-pay').$response);

        return $response;
    }
}
