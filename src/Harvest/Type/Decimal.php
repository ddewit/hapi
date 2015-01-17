<?php

namespace Harvest\Type;

use Harvest\Exception;

class Decimal extends AbstractType
{
    public function marshal($value)
    {
        return (float)$value;
    }

    public function unmarshal($value)
    {
        return (string)$value;
    }
}
