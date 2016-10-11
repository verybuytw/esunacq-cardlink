<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

class AuthorizeRequest extends RequestContract
{
    /**
     * @return array
     */
    public function toArray()
    {
        return $this->getOptions()
//            ->merge([
//            'BPF' => 'N',
//            ])
            ->all();
    }
}
