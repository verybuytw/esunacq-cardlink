<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

class TokenRequest extends RequestContract
{
    public function toArray()
    {
        return $this->getConfig()->merge([
            'TxnTp' => 'V1'
        ])->all();
    }
}
