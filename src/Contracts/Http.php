<?php

namespace MingJSHK\NewebPay\Contracts;

use GuzzleHttp\Client;

interface Http
{
    /**
     * Set mock http client instance.
     *
     * @param  \GuzzleHttp\Client  $client
     * @return self
     */
    public function setHttp(Client $client);
}
