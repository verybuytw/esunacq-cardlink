<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink;

trait BuilderEncryptTrait
{
    /**
     * @param string $data
     *
     * @return string
     */
    public function encrypt($data)
    {
        return hash('sha256', $data.static::getHashKey());
    }
}
