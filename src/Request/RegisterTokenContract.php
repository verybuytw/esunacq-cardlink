<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

use Closure;

interface RegisterTokenContract
{
    public function register(Closure $callback = null);
}
