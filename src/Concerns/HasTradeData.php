<?php

namespace MingJSHK\NewebPay\Concerns;

use Illuminate\Support\Carbon;

trait HasTradeData
{
    /**
     * The newebpay trade data.
     *
     * @var array
     */
    protected $TradeData = [];

    /**
     * Get the newebpay TradeData.
     *
     * @return array
     */
    public function getTradeData()
    {
        return $this->TradeData;
    }

    /**
     * Set now timestamp.
     *
     * @return self
     */
    public function setTimestamp()
    {
        $this->timestamp = Carbon::now()->timestamp;
        $this->TradeData['TimeStamp'] = $this->timestamp;

        return $this;
    }

    /**
     * 串接版本
     *
     * @param  string|null  $version
     * @return self
     */
    public function setVersion($version = null)
    {
        $this->TradeData['Version'] = $version ?? $this->config->get('newebpay.Version');

        return $this;
    }

    /**
     * 回傳格式
     *
     * Support types: "JSON", "String"
     *
     * @param  string|null  $type
     * @return self
     */
    public function setRespondType($type = null)
    {
        $this->TradeData['RespondType'] = $type ?? $this->config->get('newebpay.RespondType');

        return $this;
    }

    /**
     * 語系
     *
     * Support types: "zh-tw", "en"
     *
     * @param  string|null  $lang
     * @return self
     */
    public function setLangType($lang = null)
    {
        $this->TradeData['LangType'] = $lang ?? $this->config->get('newebpay.LangType');

        return $this;
    }

    /**
     * 交易秒數限制
     *
     * 0: 不限制
     * 秒數下限為 60 秒，當秒數介於 1~59 秒時，會以 60 秒計算。
     * 秒數上限為 900 秒，當超過 900 秒時，會 以 900 秒計算。
     *
     * @param  int|null  $limit
     * @return self
     */
    public function setTradeLimit($limit = null)
    {
        $this->TradeData['TradeLimit'] = $limit !== null ? $limit : $this->config->get('newebpay.TradeLimit');

        return $this;
    }

    /**
     * 繳費有效期限
     *
     * @param  int|null  $day
     * @return self
     */
    public function setExpireDate($day = null)
    {
        $day = $day !== null ? $day : $this->config->get('newebpay.ExpireDate');

        $this->TradeData['ExpireDate'] = Carbon::now()->addDays($day)->format('Ymd');

        return $this;
    }

    /**
     * 付款完成後導向頁面
     *
     * 僅接受 port 80 or 443
     *
     * @param  string|null  $url
     * @return self
     */
    public function setReturnURL($url = null)
    {
        $this->TradeData['ReturnURL'] = $url ?? $this->config->get('newebpay.ReturnURL');

        return $this;
    }

    /**
     * 付款完成後的通知連結
     *
     * 以幕後方式回傳給商店相關支付結果資料
     * 僅接受 port 80 or 443
     *
     * @param  string|null  $url
     * @return self
     */
    public function setNotifyURL($url = null)
    {
        $this->TradeData['NotifyURL'] = $url ?? $this->config->get('newebpay.NotifyURL');

        return $this;
    }

    /**
     * 商店取號網址
     *
     * 此參數若為空值，則會顯示取號結果在智付寶頁面。
     *
     * @param  string|null  $url
     * @return self
     */
    public function setCustomerURL($url = null)
    {
        $this->TradeData['CustomerURL'] = $url ?? $this->config->get('newebpay.CustomerURL');

        return $this;
    }

    /**
     * 付款取消-返回商店網址
     *
     * 當交易取消時，平台會出現返回鈕，使消費者依以此參數網址返回商店指定的頁面
     *
     * @param  string|null  $url
     * @return self
     */
    public function setClientBackURL($url = null)
    {
        $this->TradeData['ClientBackURL'] = $url ?? $this->config->get('newebpay.ClientBackURL');

        return $this;
    }

    /**
     * 付款人電子信箱是否開放修改
     *
     * @param  bool|null  $isModify
     * @return self
     */
    public function setEmailModify($isModify = null)
    {
        $this->TradeData['EmailModify'] = ($isModify !== null ? $isModify : $this->config->get('newebpay.EmailModify')) ? 1 : 0;

        return $this;
    }

    /**
     * 是否需要登入智付寶會員
     *
     * @param  bool|null  $isLogin
     * @return self
     */
    public function setLoginType($isLogin = false)
    {
        $this->TradeData['LoginType'] = ($isLogin !== null ? $isLogin : $this->config->get('newebpay.LoginType')) ? 1 : 0;

        return $this;
    }

    /**
     * 商店備註
     *
     * 1.限制長度為 300 字。
     * 2.若有提供此參數，將會於 MPG 頁面呈現商店備註內容。
     *
     * @param  string|null  $comment
     * @return self
     */
    public function setOrderComment($comment = null)
    {
        $this->TradeData['OrderComment'] = $comment !== null ? $comment : $this->config->get('newebpay.OrderComment');

        return $this;
    }

    /**
     * 支付方式
     *
     * @param  array  $arrPaymentMethod
     * @return self
     */
    public function setPaymentMethod($arrPaymentMethod = [])
    {
        $arrPaymentMethod = array_merge($this->config->get('newebpay.PaymentMethod'), $arrPaymentMethod);

        $this->TradeData['CREDIT'] = $arrPaymentMethod['CREDIT']['Enable'] ? 1 : 0;
        $this->TradeData['ANDROIDPAY'] = $arrPaymentMethod['ANDROIDPAY'] ? 1 : 0;
        $this->TradeData['SAMSUNGPAY'] = $arrPaymentMethod['SAMSUNGPAY'] ? 1 : 0;
        $this->TradeData['InstFlag'] = ($arrPaymentMethod['CREDIT']['Enable'] and $arrPaymentMethod['CREDIT']['InstFlag']) ? $arrPaymentMethod['CREDIT']['InstFlag'] : 0;
        $this->TradeData['CreditRed'] = ($arrPaymentMethod['CREDIT']['Enable'] and $arrPaymentMethod['CREDIT']['CreditRed']) ? 1 : 0;
        $this->TradeData['UNIONPAY'] = $arrPaymentMethod['UNIONPAY'] ? 1 : 0;
        $this->TradeData['WEBATM'] = $arrPaymentMethod['WEBATM'] ? 1 : 0;
        $this->TradeData['VACC'] = $arrPaymentMethod['VACC'] ? 1 : 0;
        $this->TradeData['CVS'] = $arrPaymentMethod['CVS'] ? 1 : 0;
        $this->TradeData['BARCODE'] = $arrPaymentMethod['BARCODE'] ? 1 : 0;
        $this->TradeData['P2G'] = $arrPaymentMethod['P2G'] ? 1 : 0;

        return $this;
    }

    /**
     * 付款方式-物流啟用
     *
     * 1 = 啟用超商取貨不付款
     * 2 = 啟用超商取貨付款
     * 3 = 啟用超商取貨不付款及超商取貨付款
     * null = 不開啟
     *
     * @param  int|null  $cvscom
     * @return self
     */
    public function setCVSCOM($cvscom = null)
    {
        $this->TradeData['CVSCOM'] = $cvscom !== null ? $cvscom : $this->config->get('newebpay.CVSCOM');

        return $this;
    }

    public function setTokenTerm($token = '')
    {
        $this->TradeData['TokenTerm'] = $token;

        return $this;
    }

    public function setOrder($no, $amt, $desc, $email)
    {
        $this->TradeData['MerchantOrderNo'] = $no;
        $this->TradeData['Amt'] = $amt;
        $this->TradeData['ItemDesc'] = $desc;
        $this->TradeData['Email'] = $email;

        return $this;
    }

    /**
     * 建立定期定額委託
     *
     * @param  string  $no 訂單編號
     * @param  int  $amt 訂單金額
     * @param  string  $desc 產品名稱
     * @param  string  $type 週期類別 (D, W, M, Y)
     * @param  int  $point 交易週期授權時間
     * @param  int  $starttype 檢查卡號模式
     * @param  int  $times  授權期數
     * @return self
     */
    public function setPeriodOrder($no, $amt, $desc, $type, $point, $starttype, $times)
    {
        $this->TradeData['MerOrderNo'] = $no;
        $this->TradeData['PeriodAmt'] = $amt;
        $this->TradeData['ProdDesc'] = $desc;
        $this->TradeData['PeriodType'] = $type;
        $this->TradeData['PeriodPoint'] = $point;
        $this->TradeData['PeriodStartType'] = $starttype;
        $this->TradeData['PeriodTimes'] = $times;
        return $this;
    }

    /**
     * 修改定期定額委託
     *
     * @param  string  $no 訂單編號
     * @param  string  $periodno 委託編號
     * @param  string  $type 狀態類別 (suspend, terminate, restart)
     * @return self
     */
    public function setPeriodAlterStatus($no, $periodno, $type){
        $this->TradeData['MerOrderNo'] = $no;
        $this->TradeData['PeriodNo'] = $periodno;
        $this->TradeData['AlterType'] = $type;
        return $this;
    }

    /**
     * 修改信用卡定期定額委託內容
     *
     * @param  string  $no 訂單編號
     * @param  string  $periodno 委託編號
     * @param  string  $type 週期類別 (D, W, M, Y)
     * @param  int  $point 交易週期授權時間
     * @param  int  $times  授權期數
     * @param  string  $extday 信用卡到期日 (2021 年 5 月則填入『0521』)
     * @return self
     */
    public function setPeriodAlterAmt($no, $periodno, $amt, $type, $point, $times, $extday){
        $this->TradeData['MerOrderNo'] = $no;
        $this->TradeData['PeriodNo'] = $periodno;
        $this->TradeData['AlterAmt'] = $amt;
        $this->TradeData['PeriodType'] = $type;
        $this->TradeData['PeriodPoint'] = $point;
        $this->TradeData['PeriodTimes'] = $times;
        $this->TradeData['Extday'] = $extday;
        return $this;
    }

    /**
     * 修改信用卡定期定額委託描述
     *
     * @param  string  $desc 訂單描述
     * @return self
     */
    public function setPeriodMemo($desc = null)
    {
        $this->TradeData['PeriodMemo'] = $desc ?? '無';
        return $this;
    }

    /**
     * 修改信用卡定期定額委託付款人電子信箱
     *
     * @param  string  $email 付款人電子信箱
     * @return self
     */
    public function setPayerEmail($email)
    {
        $this->TradeData['PayerEmail'] = $email;
        return $this;
    }

    /**
     * 修改信用卡定期定額委託是否開啟付款人資訊
     *
     * @param  string  $info 是否開啟付款人資訊 Y/N
     * @return self
     */
    public function setPaymentInfo($info = 'Y')
    {
        $this->TradeData['PaymentInfo'] = $info;
        return $this;
    }

    /**
     * 修改信用卡定期定額委託是否開啟收件人資訊
     *
     * @param  string  $info 是否開啟收件人資訊 Y/N
     * @return self
     */
    public function setOrderInfo($info = 'Y')
    {
        $this->TradeData['OrderInfo'] = $info;
        return $this;
    }

    /**
     * 定期定額扣款完成後的通知連結
     *
     * 以幕後方式回傳給商店相關支付結果資料
     * 僅接受 port 80 or 443
     *
     * @param  string|null  $url
     * @return self
     */
    public function setPeriodNotifyURL($url = null)
    {
        $this->TradeData['NotifyURL'] = $url ?? $this->config->get('newebpay.PeriodNotifyURL');

        return $this;
    }

    /**
     * 修改信用卡定期定額委託返回商店網址
     *
     * @param  string  $url 返回商店網址
     * @return self
     */
    public function setBackURL($url = null)
    {
        $this->TradeData['BackURL'] = $url ?? $this->config->get('newebpay.ClientBackURL');

        return $this;
    }

}
