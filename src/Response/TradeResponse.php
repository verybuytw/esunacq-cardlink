<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Response;

class TradeResponse extends ResponseContract
{
    /**
     * @return string
     */
    public function getTradeKey()
    {
        return $this->getResult()['TKey'];
    }
}
