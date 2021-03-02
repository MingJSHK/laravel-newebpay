<?php

namespace MingJSHK\NewebPay\Contracts;

interface Sender
{
    /**
     * Send the data to API.
     *
     * @param  array  $request
     * @param  string  $url
     * @return mixed
     */
    public function send($request, $url);
}
