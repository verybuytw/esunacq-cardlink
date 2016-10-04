<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink;

use Closure;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderEncryptTrait as Encrypt;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderHashKeyTrait as HashKey;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderOptionsTrait as Options;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\CardLinkContract;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\CommunicateRequest;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\RegisterRequest;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\RequestContract;

class RequestBuilder implements CardLinkContract, EncryptInterface
{
    use HashKey, Options, Encrypt;

    public function __construct($MAC)
    {
        $this->setHashKey($MAC);
    }

    public function communicate($options, Closure $callback = null)
    {
        $this->setOptions($options);

        $request = (new CommunicateRequest(static::getOptions()));

        return static::response($request, $callback);
    }

    public function register($options, Closure $callback = null)
    {
        $this->setOptions($options);

        $request = (new RegisterRequest(static::getOptions()));

        return static::response($request, $callback);
    }

    protected function getParameters($json)
    {
        return [
            'data' => $json,
            'mac' => static::encrypt($json),
            'ksn' => 1,
        ];
    }

    protected function response(RequestContract $request, Closure $callback = null)
    {
        $parameters = $this->getParameters($request->toJson());

        return is_null($callback) ? $parameters : $callback($parameters);
    }
}
