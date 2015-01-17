<?php

namespace Harvest\Type;

use Harvest\Exception;

class Integer extends AbstractType
{
    public function marshal($value)
    {
        if(is_numeric($value)) {
            return (int)$value;
        } else {
            throw new Exception\HarvestException(sprintf('Got invalid integer: %s', $value));
        }
    }

    public function unmarshal($value)
    {
        return (string)$value;
    }
}
