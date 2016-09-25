<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderConfigTrait as Config;

abstract class RequestContract implements Arrayable, Jsonable
{
    use Config;

    public function __construct(Collection $config)
    {
        $this->setConfig($config);
    }

    public function toJson($options = 0)
    {
        return json_encode(static::toArray(), $options);
    }
}
