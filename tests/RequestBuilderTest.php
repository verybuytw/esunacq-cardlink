<?php

namespace Tests\Payment\EsunBank\Acq\CardLink;

use VeryBuy\Payment\EsunBank\Acq\CardLink\RequestBuilder;

class RequestBuilderTest extends AbstractTestCase
{
    const AUTHORIZE_MAC = 'CI3TUCSGZU1UWLQQ1INETUJONDKRL9ET';

    const VERIFY_MAC = 'CYINGSMVWNIENBVEOOGM9KYGVTLOVM';

    protected $builder;

    protected $SID = 8089016189;

    protected $SKey = 1475685631;

    public function setUp()
    {
        /*
         * 通訊 驗證作業
         * (正式) https://card.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/commVerify
         * (測試) https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/commVerify
         *
         * 註冊作業
         * (正式) https://card.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/rgstACC
         * (測試) https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/rgstACC
         *
         * Token Key 交易作業
         * (正式) https://card.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/tknService
         * (測試) https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/tknService
         *
         * 註銷作業
         * (正式) https://card.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/cancelLink
         * (測試) https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/cancelLink
         *
         * 查詢作業
         * (正式) https://card.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/linkQuery
         * (測試) https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/linkQuery
         *
         */

        /*
         * 授權
         * (正式) https://acq.esunbank.com.tw/ACQTrans/esuncard/txnf013c
         * (測試) https://acqtest.esunbank.com.tw/ACQTrans/esuncard/txnf013c
         *
         * 取消授權
         * (正式) https://acq.esunbank.com.tw/ACQTrans/esuncard/txnf0150
         * (測試) https://acqtest.esunbank.com.tw/ACQTrans/esuncard/txnf0150
         *
         */

        $this->builder = new RequestBuilder(self::VERIFY_MAC);
    }

    public function testRequestBuilderWhenCommunicate()
    {
        $communicate = $this->builder->communicate(
            'https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/commVerify', [
            'SID' => $this->SID,
            'SKey' => $this->SKey,
        ], function ($params) {
            return $params;
        });

        $this->assertArrayHasKey('data', $communicate);
        $this->assertArrayHasKey('ksn', $communicate);
        $this->assertArrayHasKey('mac', $communicate);
        $this->assertArrayHasKey('TxnTp', json_decode($communicate['data'], true));
    }

    public function testRequestBuilderWhenRegisterForm()
    {
        $registerForm = $this->builder->registerForm(
            'https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/rgstACC', [
            'SID' => $this->SID,
            'SKey' => $this->SKey,
            'txToken' => 'THIS IS TEST TOKEN',
        ], function ($params) {
            return $params;
        });

        $this->assertArrayHasKey('data', $registerForm);
        $this->assertArrayHasKey('ksn', $registerForm);
        $this->assertArrayHasKey('mac', $registerForm);
        $this->assertArrayHasKey('txToken', json_decode($registerForm['data'], true));
    }

    public function testRequestBuilderWhenTrade()
    {
        $registerForm = $this->builder->trade(
            'https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/tknService', [
            'SID' => $this->SID,
            'SKey' => $this->SKey,
            'txToken' => 'THIS IS TEST TOKEN',
            'LKey' => 'THIS IS AccessToken(LKey)',
            'OrderNo' => sprintf('TO%08d', 1),
            'TxnAmt' => 1000,
            'TxnDesc' => 'test description',
            'rData' => 'transfer trade data',
        ], function ($params) {
            return $params;
        });

        $this->assertArrayHasKey('data', $registerForm);
        $this->assertArrayHasKey('ksn', $registerForm);
        $this->assertArrayHasKey('mac', $registerForm);
        $this->assertArrayHasKey('txToken', json_decode($registerForm['data'], true));
    }
}
