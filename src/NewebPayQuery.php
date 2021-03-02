<?php

namespace MingJSHK\NewebPay;

class NewebPayQuery extends BaseNewebPay
{
    protected $CheckValues;

    /**
     * The newebpay boot hook.
     *
     * @return void
     */
    public function boot()
    {
        $this->setApiPath('API/QueryTradeInfo');
        $this->setAsyncSender();

        $this->CheckValues['MerchantID'] = $this->MerchantID;
    }

    public function setQuery($no, $amt)
    {
        $this->CheckValues['MerchantOrderNo'] = $no;
        $this->CheckValues['Amt'] = $amt;

        return $this;
    }

    /**
     * Get request data.
     *
     * @return array
     */
    public function getRequestData()
    {
        $CheckValue = $this->queryCheckValue($this->CheckValues, $this->HashKey, $this->HashIV);

        return [
            'MerchantID' => $this->MerchantID,
            'Version' => $this->config->get('newebpay.Version'),
            'RespondType' => $this->config->get('newebpay.RespondType'),
            'CheckValue' => $CheckValue,
            'TimeStamp' => $this->timestamp,
            'MerchantOrderNo' => $this->CheckValues['MerchantOrderNo'],
            'Amt' => $this->CheckValues['Amt'],
        ];
    }
}
