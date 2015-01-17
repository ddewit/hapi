<?php


namespace Harvest\HttpClient;

use Harvest\Exception;

class HttpResponse
{
    protected $request = null;
    protected $code = null;
    protected $data = null;
    protected $headers = null;

    /**
     * @param string|int $code HTTP response code (i.e. 500)
     * @param array $data Data returned by the server
     * @param array $headers Headers returned by the server
     */
    public function __construct($curlHandle, $code = null, $data = null, $headers = null)
    {
        $this->request = curl_getinfo($curlHandle)['request_header'];
        $this->code = (int)$code;
        $this->data = $data;
        $this->headers = $headers;

        // $this->handleUnsuccessfull();
    }
    
    /**
     * Throw an exception if request failed
     *
     * @return void
     */
    protected function handleUnsuccessfull() {
        switch($this->code) {
            case 401:
                throw new Exception\HarvestAuthenticationException($this->get('headers')['Hint']);
                break;

            case 400:
            case 403:
            case 404:
            case 500:
            case 501:
            case 502:
                throw new Exception\HarvestRuntimeException($this->get('headers')['Status']);
                break;

            case 503:
                throw new Exception\HarvestApiLimitExceedException(sprintf("Retry after %s seconds", $this->get('headers')['Retry-After']));
                break;
        }
    }

    /**
     * @see get
     */
    public function __get($property)
    {
        return $this->get($property);
    }

    /**
     * Return the specified property
     *
     * @param  mixed $property
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
                    throw new Exception\HarvestException(sprintf('Unknown property %s::%s', get_class($this), $property));
                }
            break;
        }
    }

    /**
     * @see set
     */
    public function __set($property, $value)
    {
        $this->set($property, $value);
    }

    /**
     * Set value of the specified property
     *
     * @param mixed $property
     * @param mixed $value
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
                throw new Exception\HarvestException(sprintf('Unknown property %s::%s', get_class($this), $property));
            break;
        }
    }

    /**
     * Check if request was successful
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return ("2" === substr($this->code, 0, 1));
    }

}
