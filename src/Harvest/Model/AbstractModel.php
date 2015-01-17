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

    public function marshalValue($value, $type) {
        if(empty($value)) {
            return null;
        }

        switch($type) {
            case "":
            case "string":
                return (string)$value;
                break;

            case "integer":
                if(is_numeric($value)) {
                    return (int)$value;
                } else {
                    throw new Exception\HarvestException(sprintf('Got invalid integer: %s', $value));
                }
                break;

            case "dateTime":
                $date = \DateTime::createFromFormat(\DateTime::ISO8601, $value);
                if($date) {
                    return $date;
                } else {
                    throw new Exception\HarvestException(sprintf('Got invalid datetime (not ISO8601): %s', $value));
                }
                break;

            case "date":
                $date = \DateTime::createFromFormat('Y-m-d', $value);
                if($date) {
                    return $date;
                } else {
                    throw new Exception\HarvestException(sprintf('Got invalid date (not YYYY-MM-DD): %s', $value));
                }
                break;

            case "boolean":
                if($value === 'true' || $value === 'false') {
                    return ($value === 'true');
                } else {
                    throw new Exception\HarvestException(sprintf('Got invalid boolean: %s', $value));
                }
                break;

            default:
                throw new Exception\HarvestException(sprintf('Got unexpected type: %s', $type));
                break;
        }
    }

    public function unmarshalValue($value) {
        $type = gettype($value);
        if($type === 'object') { // TODO: nasty
            $type = get_class($value);
        }

        switch($type) {
            case "":
            case "string":
                return (string)$value;
                break;

            case "integer":
                return (string)$value;
                break;

            case "DateTime":
                return $value->format(\DateTime::ISO8601);
                break;

            case "boolean":
                return ($value === true) ? 'true' : 'false';
                break;

            default:
                throw new Exception\HarvestException(sprintf('Got unexpected type %s', $type));
                break;
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
                $value = $this->marshalValue($item->nodeValue, $item->getAttribute('type'));
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
            $value = $this->unmarshalValue($value);
            $xml .= sprintf("\t<%s>%s</%1\$s>\n", $key, htmlspecialchars($value, ENT_XML1));
        }
        $xml .= "</$this->_root>";

        return $xml;
    }

}
