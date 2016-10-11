<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Collection;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderAuthorizeTrait as Authorize;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderEncryptTrait as Encrypt;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderHashKeyTrait as HashKey;
use VeryBuy\Payment\EsunBank\Acq\CardLink\BuilderOptionsTrait as Options;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\AuthorizeRequest;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\CardLinkContract;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\CommunicateRequest;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\QueryRequest;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\RegisterRequest;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\RequestContract;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\TradeRequest;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Response\AuthorizeResponse;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Response\CommunicateResponse;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Response\QueryResponse;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Response\TradeResponse;

class RequestBuilder implements CardLinkContract, EncryptInterface
{
    use HashKey, Options, Encrypt, Authorize;

    /**
     * @param string $MAC
     */
    public function __construct($MAC)
    {
        $this->setHashKey($MAC);
    }

    /**
     * @param string       $targetUrl
     * @param array        $options
     * @param Closure|null $callback
     *
     * @return CommunicateResponse
     */
    public function communicate($targetUrl, $options, Closure $callback = null)
    {
        $this->setOptions($options);

        $request = (new CommunicateRequest(static::getOptions()));

        $next = function ($params) use ($targetUrl) {
            try {
                $response = (new Client())->request(
                    'POST', $targetUrl, ['form_params' => $params]
                );
            } catch (RequestException $e) {
                $response = $e->getResponse();
            }

            return new CommunicateResponse($response);
        };

        return static::response($request, [$next, $callback]);
    }

    public function registerForm($targetUrl, $options, Closure $callback = null)
    {
        $this->setOptions($options);

        $request = (new RegisterRequest(static::getOptions()));

        $next = function ($params) use ($targetUrl) {
            $inputs = Collection::make($params)
                ->map(function ($value, $name) {
                    return sprintf('<input type="text" name="%s" value=\'%s\' />', $name, $value);
                })->flatten()->implode('');

            $uid = uniqid();

            $submit = '<button type="submit"></button>';

            $script = sprintf('<script>document.getElementById("%s").submit();</script>', $uid);

            return sprintf(
                '<form id="%s" method="POST" action="%s">%s%s</form>%s',
                $uid,
                'https://cardtest.esunbank.com.tw/EsunCreditweb/txnproc/cardLink/rgstACC',
                $inputs,
                $submit,
                $script
            );
        };

        return static::response($request, [$next, $callback]);
    }

    public function trade($targetUrl, $options, Closure $callback = null)
    {
        $this->setOptions($options);

        $request = (new TradeRequest(static::getOptions()));

        $next = function ($params) use ($targetUrl) {
            try {
                $response = (new Client())->request(
                    'POST', $targetUrl, ['form_params' => $params]
                );
            } catch (RequestException $e) {
                $response = $e->getResponse();
            }

            return new TradeResponse($response);
        };

        return static::response($request, [$next, $callback]);
    }

    public function query($targetUrl, $options, Closure $callback = null)
    {
        $this->setOptions($options);

        $request = (new QueryRequest(static::getOptions()));

        $next = function ($params) use ($targetUrl) {
            try {
                $response = (new Client())->request(
                    'POST', $targetUrl, ['form_params' => $params]
                );
            } catch (RequestException $e) {
                $response = $e->getResponse();
            }

            return new QueryResponse($response);
        };

        return static::response($request, [$next, $callback]);
    }

    protected function getParameters($json)
    {
        return [
            'data' => $json,
            'mac' => static::encrypt($json),
            'ksn' => 1,
        ];
    }

    protected function response(RequestContract $request, array $callbacks)
    {
        list($next, $callback) = $callbacks;

        $params = $this->getParameters($request->toJson());

        return is_null($callback) ? $next($params) : $callback($params);
    }
}
