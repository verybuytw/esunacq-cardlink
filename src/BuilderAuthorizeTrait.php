<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\AuthorizeRequest;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Response\AuthorizeResponse;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Request\UnauthorizeRequest;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Response\UnauthorizeResponse;

trait BuilderAuthorizeTrait
{
    public function authorize($targetUrl, $options, Closure $callback = null, $proxy = null)
    {
        $this->setOptions($options);

        $request = (new AuthorizeRequest(static::getOptions()));

        $next = function ($params) use ($targetUrl, $proxy) {
            try {
                $request_arguments = ['form_params' => $params];
                if ($proxy) {
                    $request_arguments['proxy'] = $proxy;
                }
                $response = (new Client())->request(
                    'POST', $targetUrl, $request_arguments
                );
            } catch (RequestException $e) {
                $response = $e->getResponse();
            }

            return new AuthorizeResponse($response);
        };

        return static::response($request, [$next, $callback]);
    }

    public function unauthorize($targetUrl, $options, Closure $callback = null, $proxy = null)
    {
        $this->setOptions($options);

        $request = (new UnauthorizeRequest(static::getOptions()));

        $next = function ($params) use ($targetUrl, $proxy) {
            try {
                $request_arguments = ['form_params' => $params];
                if ($proxy) {
                    $request_arguments['proxy'] = $proxy;
                }
                $response = (new Client())->request(
                    'POST', $targetUrl, $request_arguments
                );
            } catch (RequestException $e) {
                $response = $e->getResponse();
            }

            return new UnauthorizeResponse($response);
        };

        return static::response($request, [$next, $callback]);
    }
}
