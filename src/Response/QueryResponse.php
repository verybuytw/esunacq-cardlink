<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Response;

class QueryResponse extends ResponseContract
{
    /**
     * @return array
     */
    public function info()
    {
        return $this->getResult();
    }
}
