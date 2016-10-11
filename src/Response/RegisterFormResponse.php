<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Response;

class RegisterFormResponse extends ResponseContract
{
    protected function parseResponseContents()
    {
        $response = $this->getResponse();

        $this->result = $this->parse($response['data']);

        return $this;
    }
}
