<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Response;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use VeryBuy\Payment\EsunBank\Acq\CardLink\Response\ResponseMessageTrait as ResponseMessage;

abstract class ResponseContract
{
    use ResponseMessage;

    const RESPONSE_CODE_OK = '00';

    /**
     * @var RequestException
     */
    protected $exception;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $result = [];

    /**
     * @param Response $response
     */
    public function __construct($response)
    {
        if (is_null($response)) {
            throw new InvalidArgumentException('response contract can not put null in construct.');
        }

        if ($response instanceof RequestException) {
            $this->exception = $response;
            $response = $response->getResponse();
        }

        $this->setResponse($response);
    }

    /**
     * @param Response $response
     *
     * @return ResponseContract
     */
    protected function setResponse($response)
    {
        $this->response = $response;

        return $this->parseResponseContents();
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return ($this->getResponse()->getStatusCode() < 400) and
            $this->isSuccessfulByContents();
    }

    /**
     * @return bool
     */
    protected function isSuccessfulByContents()
    {
        return $this->getResponseCode() == self::RESPONSE_CODE_OK;
    }

    /**
     * @param string $contents
     *
     * @return array
     */
    protected function parse($contents)
    {
        return json_decode($contents, true);
    }

    /**
     * @return ResponseContract
     */
    protected function parseResponseContents()
    {
        $contents = $this->getResponse()
            ->getBody()
            ->getContents();

        $this->result = $this->parse($contents);

        return $this;
    }

    /**
     * @return string
     */
    protected function getResponseCode()
    {
        return $this->getResult()['RtnCD'];
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->parseMessage($this->getResponseCode());
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }
}
