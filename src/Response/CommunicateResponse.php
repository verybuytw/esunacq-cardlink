<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Response;

class CommunicateResponse extends ResponseContract
{
    /**
     * @return string
     */
    public function token()
    {
        return $this->getResult()['txToken'];
    }
}
