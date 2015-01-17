<?php

namespace Harvest\Model;

use Harvest\Exception;

abstract class AbstractModel
{
    protected $_root = "";
    protected $_convert = true;
    protected $_values = array();

    /**
     * magic method to return non public properties
     *
     * @see     get
     * @param  mixed $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->get($property);
    }

    /**
     * get specifed property
     *
     * @param  mixed $property
     * @return mixed
     */
    public function get($property)
    {
        $value = null;

        if ($this->_convert) {
            $property = str_replace("_", "-", $property);
        } else {
            $property = str_replace("-", "_", $property);
        }

        if (array_key_exists($property, $this->_values)) {
            return $this->_values[$property];
        } else {
            return null;
        }

    }

    /**
     * magic method to set non public properties
     *
     * @see    set
     * @param  mixed $property
     * @param  mixed $value
     * @return void
     */
    public function __set($property, $value)
    {
        $this->set($property, $value);
    }

    /**
     * set property to specified value
     *
     * @param  mixed $property
     * @param  mixed $value
     * @return void
     */
    public function set($property, $value)
    {
        if ($this->_convert) {
            $property = str_replace("_", "-", $property);
        } else {
            $property = str_replace("-", "_", $property);
        }

        $this->_values[$property] = $value;
    }

    /**
     * magic method used for method overloading
     *
     * @param  string $method name of the method
     * @param  array  $args   method arguments
     * @return mixed  the return value of the given method
     */
    public function __call($method, $arguments)
    {
        if (count($arguments) == 0) {
            return $this->get($method);
        } elseif (count($arguments) == 1) {
            return $this->set($method, $arguments[0]);
        }

        throw new Exception\HarvestException(sprintf('Unknown method %s::%s', get_class($this), $method));
    }

    /**
     * Cast XML typed value to native PHP value
     *
     * @param string $value
     * @return mixed $value
     */
    public function marshalValue($value, $type = 'string') {
        if(empty($value)) {
            return null;
        }

        $type = ucfirst($type);

        if(class_exists("\\Harvest\\Type\\{$type}")) {
            $className = "\\Harvest\\Type\\{$type}";
            $type = new $className;
            return $type->marshal($value);
        } else {
            throw new \InvalidArgumentException(sprintf('Got unexpected type while marshaling: %s', $type));
        }
    }

    /**
     * Cast native PHP value to XML typed value
     *
     * @param mixed $value
     * @return string $value
     */
    public function unmarshalValue($value) {
        $type = gettype($value);
        if($type === 'object') { // TODO: nasty
            $type = get_class($value);
        }

        if(class_exists("\\Harvest\\Type\\{$type}")) {
            $className = "\\Harvest\\Type\\{$type}";
            $type = new $className;
            return $type->unmarshal($value);
        } else {
            throw new \InvalidArgumentException(sprintf('Got unexpected type while unmarshaling: %s', $type));
        }
    }

    /**
     * magic method used for method overloading
     *
     * @param  XMLNode $node xml node to parse
     * @return void
     */
    public function parseXml($node)
    {
        foreach ($node->childNodes as $item) {
            if ($item->nodeName !== "#text") {
                if($item->hasAttribute('type')) {
                    $value = $this->marshalValue($item->nodeValue, $item->getAttribute('type'));
                } else {
                    $value = $this->marshalValue($item->nodeValue);
                }
                $this->set($item->nodeName, $value);
            }
        }
    }

    /**
     * Convert Harvest Object to XML representation
     *
     * @return string
     */
    public function toXml()
    {
        $xml = "<$this->_root>\n";
        foreach ($this->_values as $key => $value) {
            $value = htmlspecialchars($this->unmarshalValue($value), ENT_XML1);
            $xml .= sprintf("\t<%s>%s</%1\$s>\n", $key, $value);
        }
        $xml .= "</$this->_root>";

        return $xml;
    }

}
