<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

class UnauthorizeRequest extends RequestContract
{
    /**
     * @return array
     */
    public function toArray()
    {
        return $this->getOptions()->all();
    }
}
