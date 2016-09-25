<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink;

use Illuminate\Support\Collection;
use InvalidArgumentException;

trait BuilderConfigTrait
{
    /**
     * @var mixed Collection|null
     */
    protected $config;

    /**
     * @param Collection|array $config
     *
     * @return self
     */
    public function setConfig($config)
    {
        if (!(is_array($config) or ($config instanceof Collection))) {
            throw new InvalidArgumentException('Config was not allow type.');
        }

        if (is_array($config)) {
            $this->config = Collection::make($config);
        }

        if ($config instanceof Collection) {
            $this->config = $config;
        }

        return $this;
    }

    /**
     * @return mixed Collection|null
     */
    public function getConfig()
    {
        return $this->config;
    }
}
