<?php

namespace MingJSHK\NewebPay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \MingJSHK\NewebPay\NewebPayMPG payment(string $no, int $amt, string $desc, string $email) 付款
 * @method static \MingJSHK\NewebPay\NewebPayCancel creditCancel(string $no, int $amt, string $type = 'order')
 * @method static \MingJSHK\NewebPay\NewebPayClose requestPayment(string $no, int $amt, string $type = 'order')
 * @method static \MingJSHK\NewebPay\NewebPayClose requestRefund(string $no, int $amt, string $type = 'order')
 * @method static \MingJSHK\NewebPay\NewebPayQuery query(string $no, int $amt)
 * @method static \MingJSHK\NewebPay\NewebPayCreditCard creditcardFirstTrade(array $data)
 * @method static \MingJSHK\NewebPay\NewebPayCreditCard creditcardTradeWithToken(array $data)
 * @method static mixed decode(string $encryptString)
 *
 * @see \MingJSHK\NewebPay\NewebPay
 */
class NewebPay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \MingJSHK\NewebPay\NewebPay::class;
    }
}
