<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink;

use Closure;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderConfigTrait as Config;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderEncryptTrait as Encrypt;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderHashKeyTrait as HashKey;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\RegisterTokenContract;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\TokenRequest;

class RequestBuilder implements RegisterTokenContract, EncryptInterface
{
    use HashKey, Config, Encrypt;

    public function __construct($MAC, array $options)
    {
        $this->setHashKey($MAC)
            ->setConfig($options);
    }

    public function register(Closure $callback = null)
    {
        $json = (new TokenRequest(static::getConfig()))->toJson();

        $parameters = $this->getParameters($json);

        return is_null($callback) ? $parameters : $callback($parameters);
    }

    protected function getParameters($json)
    {
        return [
            'data' => $json,
            'mac' => static::encrypt($json),
            'ksn' => 1,
        ];
    }
}
