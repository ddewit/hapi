<?php

namespace Harvest\Type;

use Harvest\Exception;

class Date extends AbstractType
{
    public function marshal($value)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $value);
        if($date) {
            return $date;
        } else {
            throw new Exception\HarvestException(sprintf('Got invalid date (not YYYY-MM-DD): %s', $value));
        }
    }

    public function unmarshal($value)
    {
        // TODO: also accept date() or time()?
        return $value->format('Y-m-d');
    }
}
