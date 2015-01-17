<?php

namespace Harvest\Type;

use Harvest\Exception;

class Decimal extends AbstractType
{
    public function marshal($value)
    {
        if(is_numeric($value)) {
            return (float)$value;
        } else {
            throw new Exception\HarvestException(sprintf('Got invalid decimal: %s', $value));
        }
    }

    public function unmarshal($value)
    {
        return (string)$value;
    }
}
