<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Response;

class RegisterFormResponse extends ResponseContract
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->isSuccessfulByContents();
    }

    /**
     * @return RegisterFormResponse
     */
    protected function parseResponseContents()
    {
        $response = $this->getResponse();

        $this->result = $this->parse($response['data']);

        return $this;
    }

    public function getAccessToken()
    {
        return $this->getResult()['LKey'];
    }
}
