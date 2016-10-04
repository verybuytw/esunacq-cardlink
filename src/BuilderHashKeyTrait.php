<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink;

trait BuilderHashKeyTrait
{
    /**
     * @var string
     */
    protected $hashKey;

    /**
     * @param string $hashKey
     *
     * @return self
     */
    public function setHashKey($hashKey)
    {
        $this->hashKey = $hashKey;

        return $this;
    }

    /**
     * @return string
     */
    protected function getHashKey()
    {
        return $this->hashKey;
    }
}
