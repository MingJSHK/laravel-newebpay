<?php

namespace MingJSHK\NewebPay;

class NewebPayPeriod extends BaseNewebPay
{
    /**
     * The newebpay boot hook.
     *
     * @return void
     */
    public function boot()
    {

        $this->setApiPath('MPG/period');
        $this->setVersion($this->config->get('newebpay.PeriodVersion'));
        $this->setSyncSender();
        $this->setLangType();
        $this->setReturnURL();
        $this->setEmailModify();
        $this->setPaymentInfo();
        $this->setOrderInfo();
        $this->setNotifyURL();
        $this->setBackURL();
        $this->setPeriodMemo();
    }

    /**
     * Get request data.
     *
     * @return array
     */
    public function getRequestData()
    {
        $tradeInfo = $this->encryptDataByAES($this->TradeData, $this->HashKey, $this->HashIV);

        return [
            'MerchantID_' => $this->MerchantID,
            'PostData_' => $tradeInfo,
        ];
    }
}
