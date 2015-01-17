<?php

namespace Harvest\Type;

use Harvest\Exception;

class DateTime extends AbstractType
{
    public function marshal($value)
    {
        $date = \DateTime::createFromFormat(\DateTime::ISO8601, $value);
        if($date) {
            return $date;
        } else {
            throw new Exception\HarvestException(sprintf('Got invalid datetime (not ISO8601): %s', $value));
        }
    }

    public function unmarshal($value)
    {
        return $value->format(\DateTime::ISO8601);
    }
}
