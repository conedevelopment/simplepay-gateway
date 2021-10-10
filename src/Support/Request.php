<?php

namespace Cone\SimplePay\Support;

use Exception;

class Request
{
    /**
     * The request method.
     *
     * @var string
     */
    protected $method = 'GET';

    /**
     * The request URL.
     *
     * @var string
     */
    protected $url;

    /**
     * The request body.
     *
     * @var string
     */
    protected $body = '';

    /**
     * The request headers.
     *
     * @var array
     */
    protected $headers = [
        'Content-type' => 'application/json',
    ];

    /**
     * The request response.
     *
     * @var array
     */
    protected $response = [];

    /**
     * Create a new request instance.
     *
     * @param  string  $method
     * @param  string  $url
     * @param  string  $body
     * @param  array  $headers
     * @return void
     */
    public function __construct($method, $url, $body = '', $headers = [])
    {
        $this->url = $url;
        $this->body = $body;
        $this->method = $method;
        $this->headers = array_merge($this->headers, $headers, ['Signature' => Hash::make($body)]);
    }

    /**
     * Make a new request.
     *
     * @param  string  $method
     * @param  string  $url
     * @param  string  $body
     * @param  array  $headers
     * @return static
     */
    public static function make($method, $url, $body = '', $headers = [])
    {
        return new static($method, $url, $body, $headers);
    }

    /**
     * Make a new POST request.
     *
     * @param  string  $url
     * @param  string  $body
     * @param  array  $headers
     * @return static
     */
    public static function post($url, $body = '', $headers = [])
    {
        return new static('POST', $url, $body, $headers);
    }

    /**
     * Make a new GET request.
     *
     * @param  string  $url
     * @param  string  $body
     * @param  array  $headers
     * @return static
     */
    public static function get($url, $body = '', $headers = [])
    {
        return new static('GET', $url, $body, $headers);
    }

    /**
     * Send the request.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function send()
    {
        $response = wp_remote_request($this->url, [
            'body' => $this->body,
            'method' => $this->method,
            'headers' => $this->headers,
        ]);

        if (is_wp_error($response)) {
            Log::info($response->get_error_message());
            throw new Exception($response->get_error_message());
        }

        $this->response = $response;
    }

    /**
     * Check if valid request.
     *
     * @return bool
     */
    public function valid()
    {
        return ! empty($this->response)
            && ! $this->body('errorCodes')
            && Hash::check($this->header('signature'), $this->response('body'));
    }

    /**
     * Get the response.
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function response($key = null)
    {
        if (is_null($key)) {
            return $this->response;
        }

        return Arr::get($this->response, $key);
    }

    /**
     * Get the response header.
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function header($key = null)
    {
        if (is_null($key)) {
            return $this->response['headers'];
        }

        return Arr::get($this->response['headers'], $key);
    }

    /**
     * Get the response body.
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function body($key = null)
    {
        $body = json_decode($this->response['body'], true);

        if (is_null($key)) {
            return $body;
        }

        return Arr::get($body, $key);
    }
}
