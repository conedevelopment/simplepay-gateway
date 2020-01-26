<?php

namespace Pine\SimplePay\Requests;

use Pine\SimplePay\Support\Hash;

abstract class Request
{
    /**
     * The API url.
     *
     * @var string
     */
    protected $url;

    /**
     * The request response.
     *
     * @var array
     */
    protected $response = [];

    /**
     * The body.
     *
     * @var string|array
     */
    protected $body = [];

    /**
     * The headers.
     *
     * @var array
     */
    protected $headers = [
        'Content-type' => 'application/json',
    ];

    /**
     * Send a GET request.
     *
     * @return array
     */
    public function get()
    {
        $this->response = wp_remote_get($this->url, [
            'body' => $this->body,
            'headers' => $this->headers,
        ]);

        return [
            'body' => $this->response['body'],
            'signature' => $this->response['headers']['signature'],
        ];
    }

    /**
     * Send a POST request.
     *
     * @return array
     */
    public function post()
    {
        $this->response = wp_remote_post($this->url, [
            'body' => $this->body,
            'headers' => $this->headers,
        ]);

        return [
            'body' => $this->response['body'],
            'signature' => $this->response['headers']['signature'],
        ];
    }

    /**
     * Check if valid request.
     *
     * @return bool
     */
    public function valid()
    {
        $body = json_decode($this->response['body'], true);

        return (! isset($body['errorCodes']))
            && Hash::check($this->response['headers']['signature'], $this->response['body']);
    }
}
