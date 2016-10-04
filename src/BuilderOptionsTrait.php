<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink;

use Illuminate\Support\Collection;
use InvalidArgumentException;

trait BuilderOptionsTrait
{
    /**
     * @var mixed Collection|null
     */
    protected $options;

    /**
     * @param Collection|array $options
     *
     * @return self
     */
    public function setOptions($options)
    {
        if (!(is_array($options) or ($options instanceof Collection))) {
            throw new InvalidArgumentException('Options was not allow type.');
        }

        if (is_array($options)) {
            $this->options = Collection::make($options);
        }

        if ($options instanceof Collection) {
            $this->options = $options;
        }

        return $this;
    }

    /**
     * @return mixed Collection|null
     */
    public function getOptions()
    {
        return $this->options;
    }
}
