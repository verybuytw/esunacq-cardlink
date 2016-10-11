<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Response;

class QueryResponse extends ResponseContract
{
    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->getResult();
    }
}
