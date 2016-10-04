<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

use Closure;

interface CardLinkContract
{
    public function communicate($options, Closure $callback = null);
    public function register($options, Closure $callback = null);
}
