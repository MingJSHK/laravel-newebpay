# Laravel NewebPay - 藍新金流

> Fork from [ycs77/laravel-newebpay](https://github.com/ycs77/laravel-newebpay)

[![Latest Stable Version](https://poser.pugx.org/mingjshk/laravel-newebpay/v)](//packagist.org/packages/mingjshk/laravel-newebpay)
[![Total Downloads](https://poser.pugx.org/mingjshk/laravel-newebpay/downloads)](//packagist.org/packages/mingjshk/laravel-newebpay)
[![License](https://poser.pugx.org/mingjshk/laravel-newebpay/license)](//packagist.org/packages/mingjshk/laravel-newebpay)

Laravel NewebPay 為針對 Laravel 所寫的金流套件，主要實作藍新金流（原智付通）功能。
Now Support Laravel 8

主要實作項目：

* NewebPay MPG - 多功能收款
* NewebPay Cancel - 信用卡取消授權
* NewebPay Close - 信用卡請退款
* NewebPay Period - 信用卡定期定額委託
* NewebPay Alter Period Status- 信用卡定期定額委託修改狀態
* NewebPay Alter Period Amt - 信用卡定期定額修改委託

## 安裝

```
composer require mingjshk/laravel-newebpay
```

### 註冊套件

> Laravel 5.5 以上會自動註冊套件，可以跳過此步驟

在 `config/app.php` 註冊套件和增加別名：

```php
    'providers' => [
        ...

        /*
         * Package Service Providers...
         */
        MingJSHK\NewebPay\NewebPayServiceProvider::class,

        ...
    ],

    'aliases' => [
        ...

        'NewebPay' => MingJSHK\NewebPay\Facades\NewebPay::class,
    ]
```

### 發布設置檔案

```
php artisan vendor:publish --provider="MingJSHK\NewebPay\NewebPayServiceProvider"
```

## 使用

### 設定 `.env` 檔

```
// .env

NEWEBPAY_MERCHANT_ID=""
NEWEBPAY_HASH_KEY=""
NEWEBPAY_HASH_IV=""
NEWEBPAY_DEBUG=true/false

NEWEBPAY_RETURN_URL=""
NEWEBPAY_NOTIFY_URL=""
NEWEBPAY_PERIOD_NOTIFY_URL=""
NEWEBPAY_CLIENT_BACK_URL=""
```

### 設定 `config/newebpay.php`

可依據個人商業使用上做調整。

### 引用、初始化類別：

```
use MingJSHK\NewebPay\NewebPay;

$newebpay = new NewebPay();
```

### NewebPay MPG - 多功能支付

```php
use MingJSHK\NewebPay\Facades\NewebPay;

function order() 
{
    return NewebPay::payment(
        no, // 訂單編號
        amt, // 交易金額
        desc, // 交易描述
        email // 付款人信箱
    )->submit();
}
```

基本上一般交易可直接在 `config/newebpay.php`做設定，裡面有詳細的解說，但若遇到特殊情況，可依據個別交易做個別 function 設定。

```php
use MingJSHK\NewebPay\Facades\NewebPay;

return NewebPay::payment(
    no, // 訂單編號
    amt, // 交易金額
    desc, // 交易描述
    email // 付款人信箱
)
    ->setRespondType() // 回傳格式
    ->setLangType() // 語言設定
    ->setTradeLimit() // 交易秒數限制
    ->setExpireDate() // 交易截止日
    ->setReturnURL() // 由藍新回傳後前景畫面要接收資料顯示的網址
    ->setNotifyURL() // 由藍新回傳後背景處理資料的接收網址
    ->setCutomerURL() // 商店取號網址
    ->setClientBackURL() // 付款取消後返回的網址
    ->setEmailModify() // 是否開放 email 修改
    ->setLoginType() // 是否需要登入智付寶會員
    ->setOrderComment() //商店備註
    ->setPaymentMethod() //付款方式 *依照 config 格式傳送*
    ->setCVSCOM() // 物流方式
    ->setTokenTerm() // 快速付款 token
    ->submit();
```

*此版本1.5由籃新金流回傳後為加密訊息，所以回傳後需要進行解碼！*

```php
use Illuminate\Http\Request;
use MingJSHK\NewebPay\Facades\NewebPay;

function returnURL(Request $request)
{
    return NewebPay::decode($request->input('TradeInfo'));
}
```

### NewebPay Cancel - 信用卡取消授權

```php
use MingJSHK\NewebPay\Facades\NewebPay;

function creditCancel()
{
    return NewebPay::creditCancel(
        no, // 該筆交易的訂單編號
        amt,  // 該筆交易的金額
        'order' // 可選擇是由 order->訂單編號 或是 trade->藍新交易編號來做申請
    )->submit();
}
```

### NewebPay Close - 信用卡請款

```php
use MingJSHK\NewebPay\Facades\NewebPay;

function requestPayment()
{
    return NewebPay::requestPayment(
        no, // 該筆交易的訂單編號
        amt,  // 該筆交易的金額
        'order' // 可選擇是由 order->訂單編號 或是 trade->藍新交易編號來做申請
    )->submit();
}
```

### NewebPay close - 信用卡退款

```php
use MingJSHK\NewebPay\Facades\NewebPay;

function requestRefund()
{
    return NewebPay::requestRefund(
        no, // 該筆交易的訂單編號
        amt,  // 該筆交易的金額
        'order' // 可選擇是由 order->訂單編號 或是 trade->藍新交易編號來做申請
    )->submit();
}
```

### NewebPay Period - 定期定額委託

```php
use MingJSHK\NewebPay\Facades\NewebPay;

function period()
{
    return NewebPay::period(
            $no,        //訂單編號
            $amt,       //訂單金額
            $desc,      //產品名稱
            $type,      //週期類別 (D, W, M, Y)
            $point,     //交易週期授權時間
            $starttype, //檢查卡號模式
            $times,     //授權期數
            $email      //連絡信箱
        )->submit();
}
```

### NewebPay Period Status- 修改定期定額委託狀態

```php
use MingJSHK\NewebPay\Facades\NewebPay;

function alterPeriodStatus()
{
    return NewebPay::alterStatus(
            $no,        //訂單編號
            $periodno,  //委託編號
            $type       //狀態類別 (suspend, terminate, restart)
        )->submitAndDecode('period');
}
```

### NewebPay Period - 定期定額委託內容

```php
use MingJSHK\NewebPay\Facades\NewebPay;

function alterPeriodAmt()
{
    return NewebPay::alterPeriodAmt(
            $no,        //訂單編號
            $periodno,  //委託編號
            $amt,       //訂單金額
            $type,      //週期類別 (D, W, M, Y)
            $point,     //交易週期授權時間
            $times,     //授權期數
            $extday     //信用卡到期日 (2021 年 5 月則填入『0521』)
        )->submitAndDecode('period');
}
```

## Official Reference

[NewebPay Payment API](https://www.newebpay.com/website/Page/content/download_api#1)

## License

[MIT](./LICENSE)
