<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink\Request;

use Closure;

interface CardLinkContract
{
    /**
     * @param string  $targetUrl
     * @param array   $options
     * @param Closure $callback
     */
    public function communicate($targetUrl, $options, Closure $callback = null);

    /**
     * @param string  $targetUrl
     * @param array   $options
     * @param Closure $callback
     */
    public function registerForm($targetUrl, $options, Closure $callback = null);

    /**
     * @param string  $targetUrl
     * @param array   $options
     * @param Closure $callback
     */
    public function trade($targetUrl, $options, Closure $callback = null);

    /**
     * @param string  $targetUrl
     * @param array   $options
     * @param Closure $callback
     */
    public function query($targetUrl, $options, Closure $callback = null);

    /**
     * @param string  $targetUrl
     * @param array   $options
     * @param Closure $callback
     */
    public function authorize($targetUrl, $options, Closure $callback = null);
}
