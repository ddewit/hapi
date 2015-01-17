<?php

namespace Harvest\Type;

class AbstractType
{
    /**
     * Cast XML typed value to native PHP value
     *
     * @param string $value
     * @return mixed $value
     */
    public function marshal($value)
    {
        return $value;
    }

    /**
     * Cast native PHP value to XML typed value
     *
     * @param mixed $value
     * @return string $value
     */
    public function unmarshal($value)
    {
        return $value;
    }
}
