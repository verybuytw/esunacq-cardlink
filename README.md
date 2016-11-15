### 使用簡述
```shell
$  composer require vb-payment/esunacq-cardlink
```

#### 取得通訊鍵值 (txToken)
> 在每個 `request` 訪問前都需要問一次 `txToken`
>
> 時效性 `300` 秒


```php
<?php
    use VeryBuy\Payment\EsunBank\Acq\CardLink\RequestBuilder;

    // $mac 由玉山銀行提供`註冊`用的押碼
    $builder = new RequestBuilder($mac);

    /**
     * $SID 商家代碼
     * $SKey 使用者編號
     * $targetUrl 玉山 API 接口
     *
     * production: https://card.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/commVerify
     * testing: https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/commVerify
     */
    $communicate = $builder->communicate($targetUrl, [
        'SID' => $SID,
        'SKey' => $SKey,
    ]);

    if ($communicate->isSuccessful()) {
        print_r($communicate->getVerifyToken());
    }
```

#### 導向至玉山刷卡畫面註冊卡號
> 格式為 HTML FROM 會 `auto submit`

```php
<?php
    use VeryBuy\Payment\EsunBank\Acq\CardLink\RequestBuilder;

    // $mac 由玉山銀行提供`註冊`用的押碼
    $builder = new RequestBuilder($mac);

    /**
     * $SID 商家代碼
     * $SKey 使用者編號
     * $targetUrl 玉山 API 接口
     *
     * production: https://card.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/rgstACC
     * testing: https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/rgstACC
     *
     */
    echo $builder->registerForm($targetUrl, [
        'SID' => $SID,
        'SKey' => $SKey,
        'txToken' => $communicate->getVerifyToken(),
        'rData' => '提供商家傳值，原封不動回傳 length:200',
    ]);
```

#### 刷卡結果回傳 CardLink 鍵值 (LKey)
> 設定於一開始玉山要求的 response url
>
> 需存下來
>
> 代表著 SID + SKey 的用戶 (`SID` + `SKey` 是唯一值，意思是某家商店的某個用戶 )

```php
<?php
    use VeryBuy\Payment\EsunBank\Acq\CardLink\Response\RegisterFormResponse;

    $response = new RegisterFormResponse($_POST);

    if ($response->isSuccessful()) {
        print_r($response->getAccessToken());
    }
```

#### 取得交易 token
> 僅限一次使用
>
> 時效性 `300` 秒

```php
<?php
    use VeryBuy\Payment\EsunBank\Acq\CardLink\RequestBuilder;

    // $mac 由玉山銀行提供`註冊`用的押碼
    $builder = new RequestBuilder($mac);

    /**
     * $SID 商家代碼
     * $SKey 使用者編號
     * $targetUrl 玉山 API 接口
     *
     * production: https://card.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/tknService
     * testing: https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/tknService
     *
     */
    $trade = $builder->trade($targetUrl, [
        'SID' => $SID,
        'SKey' => $SKey,
        'txToken' => $communicate->getVerifyToken(),
        'LKey' => $response->getAccessToken(),
        'OrderNo' => sprintf('TO%08d', 3), // 訂單編號 length:50
        'TxnAmt' => 1000,   // 訂單金額
        'TxnDesc' => '顯示在 CardLink 頁面上',
        'rData' => '提供商家傳值，原封不動回傳 length:200',
    ]);

    if ($trade->isSuccessful()) {
        print_r($trade->getTradeToken());
    }
```

#### 請求授權
```php
<?php
    use VeryBuy\Payment\EsunBank\Acq\CardLink\RequestBuilder;
    use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\AuthorizeRequest;

    // $mac 由玉山銀行提供`交易`用的押碼
    $builder = new RequestBuilder($mac);

    /**
     * $MID 商家代碼 ( 等同於註冊時的 SID )
     * $targetUrl 玉山 API 接口
     *
     * production: https://acq.esunbank.com.tw/ACQTrans/esuncard/txnf013c
     * testing: https://acqtest.esunbank.com.tw/ACQTrans/esuncard/txnf013c
     *
     */
    $authorize= $builder->authorize($targetUrl, [
        'MID' => $MID,
        'TID' => AuthorizeRequest::TYPE_TRANSACTION,
        'ONO' => sprintf('TO%08d', 3), // 訂單編號，不可重複，不可包含【_】字元，英數限用大寫 length:50
        'TA' => 1000, // 訂單金額
        'TK' => $trade->getTradeToken(),
    ]);

    if ($authorize->isSuccessful()) {
        print_r($trade->getOrderNumber());
    }
```

#### 取消授權
```php
<?php
    use VeryBuy\Payment\EsunBank\Acq\CardLink\RequestBuilder;

    // $mac 由玉山銀行提供`交易`用的押碼
    $builder = new RequestBuilder($mac);

    /**
     * $MID 商家代碼 ( 等同於註冊時的 SID )
     * $targetUrl 玉山 API 接口
     *
     * production: https://acq.esunbank.com.tw/ACQTrans/esuncard/txnf0150
     * testing: https://acqtest.esunbank.com.tw/ACQTrans/esuncard/txnf0150
     *
     */
    $unauthorize = $builder->unauthorize($targetUrl, [
        'MID' => $MID,
        'ONO' => sprintf('TO%08d', 3),
    ]);

    if ($unauthorize->isSuccessful()) {
        print_r($unauthorize->getOrderNumber());
    }
```
