<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderOptionsTrait as Options;

abstract class RequestContract implements Arrayable, Jsonable
{
    use Options;

    const TYPE_COMMUNICATE = 'V1';
    const TYPE_REGISTER = 'A1';

    public function __construct(Collection $options)
    {
        $this->setOptions($options);
    }

    public function toJson($options = 0)
    {
        return json_encode(static::toArray(), $options);
    }
}
