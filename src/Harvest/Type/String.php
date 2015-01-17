<?php

namespace Harvest\Type;

use Harvest\Exception;

class String extends AbstractType
{
    public function marshal($value)
    {
        return (string)$value;
    }

    public function unmarshal($value)
    {
        return (string)$value;
    }
}
