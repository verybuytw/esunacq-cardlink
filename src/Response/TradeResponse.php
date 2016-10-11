<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Response;

class TradeResponse extends ResponseContract
{
    /**
     * @return string
     */
    public function key()
    {
        return $this->getResult()['TKey'];
    }
}
