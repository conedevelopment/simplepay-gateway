<?php

namespace Pine\SimplePay\Requests;

abstract class Request
{
    /**
     * The request response.
     *
     * @var array
     */
    protected $response = [];

    /**
     * The payload.
     *
     * @var array
     */
    protected $payload = [];

    /**
     * The URL.
     *
     * @var string
     */
    protected $url;

    /**
     * Send a GET request.
     *
     * @return void|bool
     */
    public function get()
    {
        $this->response = wp_remote_get($this->url, ['body' => $this->payload]);

        return wp_remote_retrieve_response_code($this->response) === 200;
    }

    /**
     * Send a POST request.
     *
     * @return void|bool
     */
    public function post()
    {
        $this->response = wp_remote_post($this->url, ['body' => $this->payload]);

        return wp_remote_retrieve_response_code($this->response) === 200;
    }
}
