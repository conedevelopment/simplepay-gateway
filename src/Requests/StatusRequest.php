<?php

namespace Pine\SimplePay\Requests;

use Pine\SimplePay\Payloads\StatusPayload;
use Pine\SimplePay\Support\Config;
use Pine\SimplePay\Support\Hash;

class StatusRequest extends Request
{
    /**
     * Create a new request instance.
     *
     * @param  string|array  $payload
     * @return void
     */
    public function __construct($ids)
    {
        $this->url = Config::url('query');
        $this->body = StatusPayload::handle($ids);
        $this->headers['Signature'] = Hash::make($this->body);
    }
}
