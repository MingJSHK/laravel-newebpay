<?php

namespace MingJSHK\NewebPay\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class NewebpayDecodeFailException extends Exception
{
    /**
     * Create a new newebpay decode fail exception.
     *
     * @param  \Throwable  $previous
     * @param  mixed  $errorData
     * @return void
     */
    public function __construct(Throwable $previous, $errorData)
    {
        Log::debug('The NewebPay decode error content: ', [$errorData]);

        parent::__construct('The NewebPay decode data error.', 400, $previous);
    }
}
