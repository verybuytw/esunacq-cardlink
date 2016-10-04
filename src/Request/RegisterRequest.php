<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

class RegisterRequest extends RequestContract
{
    public function toArray()
    {
        return $this->getOptions()->merge([
            'TxnTp' => RequestContract::TYPE_REGISTER,
        ])->all();
    }
}
