<?php


namespace Harvest\HttpClient;

use Harvest\Exception;

class HttpResponse
{
    protected $code = null;
    protected $data = null;
    protected $headers = null;

    /**
     * Constructor initializes {@link $code} {@link $data}
     *
     * @param string $code    response code
     * @param array  $data    array of Quote Objects
     * @param array  $headers array of Header Response values
     */
    public function __construct($code = null, $data = null, $headers = null)
    {
        $this->code = (int)$code;
        $this->data = $data;
        $this->headers = $headers;

        $this->handleUnsuccessfull();
    }

    protected function handleUnsuccessfull() {
        switch($this->code) {
            case 401:
                throw new HarvestAuthenticationException($this->get('headers')['Hint']);
                break;

            case 400:
            case 403:
            case 404:
            case 500:
            case 501:
            case 502:
                throw new HarvestRuntimeException($this->get('headers')['Status']);
                break;

            case 503:
                throw new HarvestApiLimitExceedException(sprintf("Retry after %s seconds", $this->get('headers')['Retry-After']));
                break;
        }
    }

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
     * Return the specified property
     *
     * @param  mixed $property The property to return
     * @return mixed
     */
    public function get($property)
    {
        switch ($property) {
            case 'code':
                return $this->code;
            break;
            case 'data':
                return $this->data;
            break;
            case 'headers':
                return $this->headers;
            break;
            default:
                if ($this->headers != null && array_key_exists($property, $this->headers)) {
                    return $this->headers[$property];
                } else {
                    throw new HarvestException(sprintf('Unknown property %s::%s', get_class($this), $property));
                }
            break;
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
     * sets the specified property
     *
     * @param  mixed $property The property to set
     * @param  mixed $value    value of property
     * @return void
     */
    public function set($property, $value)
    {
        switch ($property) {
            case 'code':
                $this->code = $value;
            break;
            case 'data':
                $this->data = $value;
            break;
            case 'headers':
                $this->headers = $value;
            break;
            default:
                throw new HarvestException(sprintf('Unknown property %s::%s', get_class($this), $property));
            break;
        }
    }

    /**
     * is request successfull
     * @return boolean
     */
    public function isSuccess()
    {
        if ("2" == substr($this->code, 0, 1)) {
            return true;
        } else {
            return false;
        }
    }

}
