<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Response;

class AuthorizeResponse extends ResponseContract
{
    /**
     * @param string $contents
     *
     * @return array
     */
    protected function parse($contents)
    {
        list($name, $contents) = explode('=', $contents);

        return json_decode($contents, true);
    }

    /**
     * @return string
     */
    public function getResponseCode()
    {
        return $this->getResult()['returnCode'];
    }

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        $detail = $this->getResult()['txnData'];

        return $detail['ONO'];
    }
}
