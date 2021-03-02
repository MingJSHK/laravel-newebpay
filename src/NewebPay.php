<?php

namespace MingJSHK\NewebPay;

use Throwable;
use MingJSHK\NewebPay\Exceptions\NewebpayDecodeFailException;

class NewebPay extends BaseNewebPay
{
    /**
     * 付款
     *
     * @param  string  $no 訂單編號
     * @param  int  $amt 訂單金額
     * @param  string  $desc 商品描述
     * @param  string  $email 連絡信箱
     * @return \MingJSHK\NewebPay\NewebPayMPG
     */
    public function payment($no, $amt, $desc, $email)
    {
        $newebPay = new NewebPayMPG($this->config);
        $newebPay->setOrder($no, $amt, $desc, $email);

        return $newebPay;
    }

    /**
     * 取消授權
     *
     * @param  string  $no 訂單編號
     * @param  int  $amt 訂單金額
     * @param  string  $type 編號類型
     *         'order' => 使用商店訂單編號追蹤
     *         'trade' => 使用藍新金流交易序號追蹤
     * @return \MingJSHK\NewebPay\NewebPayCancel
     */
    public function cancelCredit($no, $amt, $type = 'order')
    {
        $newebPay = new NewebPayCancel($this->config);
        $newebPay->setCancelOrder($no, $amt, $type);

        return $newebPay;
    }

    /**
     * 請款
     *
     * @param  string  $no 訂單編號
     * @param  int  $amt 訂單金額
     * @param  string  $type 編號類型
     *         'order' => 使用商店訂單編號追蹤
     *         'trade' => 使用藍新金流交易序號追蹤
     * @return \MingJSHK\NewebPay\NewebPayClose
     */
    public function requestPayment($no, $amt, $type = 'order')
    {
        $newebPay = new NewebPayClose($this->config);
        $newebPay->setCloseOrder($no, $amt, $type);
        $newebPay->setCloseType('pay');

        return $newebPay;
    }

    /**
     * 退款
     *
     * @param  string  $no 訂單編號
     * @param  int  $amt 訂單金額
     * @param  string  $type 編號類型
     *         'order' => 使用商店訂單編號追蹤
     *         'trade' => 使用藍新金流交易序號追蹤
     * @return \MingJSHK\NewebPay\NewebPayClose
     */
    public function requestRefund($no, $amt, $type = 'order')
    {
        $newebPay = new NewebPayClose($this->config);
        $newebPay->setCloseOrder($no, $amt, $type);
        $newebPay->setCloseType('refund');

        return $newebPay;
    }

    /**
     * 查詢
     *
     * @param  string  $no 訂單編號
     * @param  int  $amt 訂單金額
     * @return \MingJSHK\NewebPay\NewebPayQuery
     */
    public function query($no, $amt)
    {
        $newebPay = new NewebPayQuery($this->config);
        $newebPay->setQuery($no, $amt);

        return $newebPay;
    }

    /**
     * 信用卡授權 - 首次交易
     *
     * @param  array  $data
     *                 $data['no'] => 訂單編號
     *                 $data['email'] => 購買者 email
     *                 $data['cardNo'] => 信用卡號
     *                 $data['exp'] => 到期日 格式: 2021/01 -> 2101
     *                 $data['cvc'] => 信用卡驗證碼 格式: 3碼
     *                 $data['desc] => 商品描述
     *                 $data['amt'] => 綁定支付金額
     *                 $data['tokenTerm'] => 約定信用卡付款之付款人綁定資料
     * @return \MingJSHK\NewebPay\NewebPayCreditCard
     */
    public function creditcardFirstTrade($data)
    {
        $newebPay = new NewebPayCreditCard($this->config);
        $newebPay->firstTrade($data);

        return $newebPay;
    }

    /**
     * 信用卡授權 - 使用已綁定信用卡進行交易
     *
     * @param  array  $data
     *                $data['no'] => 訂單編號
     *                $data['amt'] => 訂單金額
     *                $data['desc'] => 商品描述
     *                $data['email'] => 購買者 email
     *                $data['tokenValue'] => 綁定後取回的 token 值
     *                $data['tokenTerm'] => 約定信用卡付款之付款人綁定資料 要與第一次綁定時一樣
     * @return \MingJSHK\NewebPay\NewebPayCreditCard
     */
    public function creditcardTradeWithToken($data)
    {
        $newebPay = new NewebPayCreditCard($this->config);
        $newebPay->tradeWithToken($data);

        return $newebPay;
    }

    /**
     * 信用卡定期定額
     *
     * @param  string  $no 訂單編號
     * @param  int  $amt 訂單金額
     * @param  string  $desc 產品名稱
     * @param  string  $type 週期類別 (D, W, M, Y)
     * @param  int  $point 交易週期授權時間
     * @param  int  $starttype 檢查卡號模式
     * @param  int  $times  授權期數
     * @param  string  $email 連絡信箱
     * @return \MingJSHK\NewebPay\NewebPayPeriod
     */
    public function period($no, $amt, $desc, $type, $point, $starttype, $times, $email)
    {
        $newebPay = new NewebPayPeriod($this->config);
        $newebPay->setPeriodOrder($no, $amt, $desc, $type, $point, $starttype, $times);
        $newebPay->setPayerEmail($email);
        return $newebPay;
    }

    /**
     * 修改信用卡定期定額委託狀態
     *
     * @param  string  $no 訂單編號
     * @param  string  $periodno 委託編號
     * @param  string  $type 狀態類別 (suspend, terminate, restart)
     * @return \MingJSHK\NewebPay\NewebPayPeriodAlterStatus
     */
    public function alterPeriodStatus($no, $periodno, $type){
        $newebPay = new NewebPayPeriodAlterStatus($this->config);
        $newebPay->setPeriodAlterStatus($no, $periodno, $type);
        return $newebPay;
    }

    /**
     * 修改信用卡定期定額委託內容
     *
     * @param  string  $no 訂單編號
     * @param  string  $periodno 委託編號
     * @param  int  $amt  訂單金額
     * @param  string  $type 週期類別 (D, W, M, Y)
     * @param  int  $point 交易週期授權時間
     * @param  int  $times  授權期數
     * @param  string  $extday 信用卡到期日 (2021 年 5 月則填入『0521』)
     * @return \MingJSHK\NewebPay\NewebPayCreditCard
     */
    public function alterPeriodAmt($no, $periodno, $amt, $type, $point, $times, $extday){
        $newebPay = new NewebPayPeriodAlterAmt($this->config);
        $newebPay->setPeriodAlterAmt($no, $periodno, $amt, $type, $point, $times, $extday);
        return $newebPay;
    }
}
