<?php

namespace MingJSHK\NewebPay;

class NewebPayPeriodAlterStatus extends BaseNewebPay
{
    /**
     * The newebpay boot hook.
     *
     * @return void
     */
    public function boot()
    {
        $this->setApiPath('MPG/period/AlterStatus');
        $this->setAsyncSender();
        $this->setVersion($this->config->get('newebpay.PeriodVersion'));
        $this->setVersion($this->config->get('newebpay.PeriodVersion'));
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
