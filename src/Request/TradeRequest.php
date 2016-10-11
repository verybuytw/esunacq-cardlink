<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

use Closure;
use InvalidArgumentException;

class TradeRequest extends RequestContract
{
    /**
     * @param Closure $success
     * @param Closure $error
     *
     * @return Closure
     */
    protected function validate(Closure $success = null, Closure $error = null)
    {
        $descLength = mb_strlen(base64_encode(static::getOptions()->get('TxnDesc')));

        return ($descLength <= 100 and $descLength > 0) ? $success() : $error();
    }

    /**
     * @return array|InvalidArgumentException
     */
    public function toArray()
    {
        $this->validate(function () {
            $this->getOptions()->put(
                'TxnDesc',
                base64_encode(static::getOptions()->get('TxnDesc'))
            );
        }, function () {
            throw new InvalidArgumentException('TxnDesc after base64 encoded, length need less than 100.');
        });

        return $this->getOptions()->merge([
            'TxnTp' => RequestContract::TYPE_TRADE,
        ])->all();
    }
}
