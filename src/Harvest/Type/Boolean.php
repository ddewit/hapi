<?php

namespace Harvest\Type;

use Harvest\Exception;

class Boolean extends AbstractType
{
    public function marshal($value)
    {
        if($value === 'true' || $value === 'false') {
            return ($value === 'true');
        } else {
            throw new Exception\HarvestException(sprintf('Got invalid boolean: %s', $value));
        }
    }

    public function unmarshal($value)
    {
        return ($value === true) ? 'true' : 'false';
    }
}
