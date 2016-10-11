<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

class QueryRequest extends RequestContract
{
    /**
     * @return array
     */
    public function toArray()
    {
        return $this->getOptions()->merge([
            'TxnTp' => RequestContract::TYPE_QUERY,
        ])->all();
    }
}
