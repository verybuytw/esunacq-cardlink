<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

class CommunicateRequest extends RequestContract
{
    public function toArray()
    {
        return $this->getOptions()->merge([
            'TxnTp' => RequestContract::TYPE_COMMUNICATE
        ])->all();
    }
}
