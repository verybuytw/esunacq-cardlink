<?php

namespace Tests\Payment\EsunBank\Acq\CardLink;

use VeryBuy\Payment\EsunBank\Acq\CardLink\RequestBuilder;

class RequestBuilderTest extends AbstractTestCase
{
    protected $MAC = ' CI3TUCSGZU1UWLQQ1INETUJONDKRL9ET';

    protected $SIC = 8089016189;

    public function testRequestBuilderWhenRegisterToken()
    {
        $builder = new RequestBuilder($this->MAC, [
            'SID' => $this->SIC,
            'SKey' => time()
        ]);

        dump($builder->register());
    }
}
