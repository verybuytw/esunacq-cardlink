<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

class AuthorizeRequest extends RequestContract
{
    const TYPE_TRANSACTION = 'EC000001';
    const TYPE_INSTALLMENT = 'EC000002';
    /**
     * @return array
     */
    public function toArray()
    {
        return $this->getOptions()
//            ->merge([
//                'BPF' => 'N',
//            ])
            ->all();
    }
}
