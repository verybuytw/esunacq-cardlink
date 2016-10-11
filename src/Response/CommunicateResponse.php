<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Response;

class CommunicateResponse extends ResponseContract
{
    /**
     * @return string
     */
    public function getVerifyToken()
    {
        return $this->getResult()['txToken'];
    }
}
