<?php

namespace Tests\Payment\EsunBank\Acq\CardLink;

use PHPUnit_Framework_TestCase;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        date_default_timezone_set('Asia/Taipei');
    }

    public function assertMethodExists($method_name, $class)
    {
        return $this->assertEquals(true, method_exists($class, $method_name));
    }
}
