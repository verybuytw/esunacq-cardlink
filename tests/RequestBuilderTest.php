<?php

namespace Tests\Payment\EsunBank\Acq\CardLink;

use VeryBuy\Payment\EsunBank\Acq\CardLink\RequestBuilder;

class RequestBuilderTest extends AbstractTestCase
{
    protected $builder;

    protected $MAC = 'CI3TUCSGZU1UWLQQ1INETUJONDKRL9ET';

    protected $SID = 8089016189;

    public function setUp()
    {
        $this->builder = new RequestBuilder($this->MAC);
    }

    public function testRequestBuilderWhenCommunicate()
    {
        $communicate = $this->builder->communicate([
            'SID' => $this->SID,
            'SKey' => time(),
        ]);

        $this->assertArrayHasKey('data', $communicate);
        $this->assertArrayHasKey('ksn', $communicate);
        $this->assertArrayHasKey('mac', $communicate);
        $this->assertArrayHasKey('TxnTp', json_decode($communicate['data'], true));
    }

    public function testRequestBuilderWhenRegister()
    {
        $communicate = $this->builder->register([
            'SID' => $this->SID,
            'SKey' => time(),
            'txToken' => 'THIS IS TEST TOKEN'
        ]);

        $this->assertArrayHasKey('data', $communicate);
        $this->assertArrayHasKey('ksn', $communicate);
        $this->assertArrayHasKey('mac', $communicate);
        $this->assertArrayHasKey('TxnTp', json_decode($communicate['data'], true));
        $this->assertArrayHasKey('txToken', json_decode($communicate['data'], true));
    }
}
