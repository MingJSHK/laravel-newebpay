<?php

namespace MingJSHK\NewebPay;

class NewebPayPeriodAlterAmt extends BaseNewebPay
{
    /**
     * The newebpay boot hook.
     *
     * @return void
     */
    public function boot()
    {
        $this->setApiPath('MPG/period/AlterAmt');
        $this->setASyncSender();
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
