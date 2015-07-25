<?php

namespace Harvest\HttpClient;

use Harvest\Model;
use Harvest\Exception;

class HttpClient
{
    /**
     * If the request fails, try again after a couple of seconds until it succeeds.
     */
    const MODE_RETRY = 'WAIT';
    
    /**
     * If the request fails, stop trying.
     */
    const MODE_FAIL = 'FAIL';
    
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_PUT = 'PUT';
    const HTTP_DELETE = 'DELETE';

    protected $mode = self::MODE_FAIL;
    protected $headers = array();
    protected $urlParameters = array();

    private $username;
    private $password;
    private $account;

    private $curlHandle;
    private $httpMode = self::HTTP_GET;
    
    public function __construct() {
        $this->curlHandle = curl_init();
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curlHandle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curlHandle, CURLINFO_HEADER_OUT, true);
        curl_setopt($this->curlHandle, CURLOPT_HEADERFUNCTION, array(&$this,'parseHeader'));
    }

    /**
     * Set authentication details for the following requests
     *
     * @param string $username
     * @param string $password
     */
    public function authenticate($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param string $account Your Harvest account name
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * Add extra headers to the existing set of headers
     *
     * @param array $headers
     */
    public function setHeaders($headers = array())
    {
        $this->headers = array_merge($this->headers, $headers);
        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, $this->headers);
    }

    /**
     * Reset the headers to the default settings
     */
    public function clearHeaders()
    {
        $this->headers = array(
            'User-Agent: Hapi / PHP Wrapper Library for Harvest API',
            'Accept: application/xml',
            'Content-Type: application/xml',
            'Authorization: Basic ' . base64_encode($this->username . ":" . $this->password),
       );
       curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, $this->headers);
    }
    
    /**
     * Add extra URL parameters to the existing set of URL parameters
     *
     * @param array $urlParameters ( key => value, key => value )
     */
    public function setUrlParameters($urlParameters = array())
    {
        $this->urlParameters = array_merge($this->urlParameters, $urlParameters);
    }
    
    /**
     * Reset the URL parameters to the default settings
     */
    public function clearUrlParameters()
    {
        $this->urlParameters = array();
    }

    /**
     * parse cURL Header text
     * @param  cURL-Handle $ch     cURL Handle
     * @param  string      $header Header line text to be parsed
     * @return int
     */
    protected function parseHeader($ch, $header)
    {
        $pos = strpos($header, ":");
        $key = substr($header, 0, $pos);
        $value = trim(substr($header, $pos + 1));
        if ($key === "Location") {
            $this->headers[$key] = trim(substr($value, strrpos($value, "/") + 1));
        } else {
            $this->headers[$key] = $value;
        }

        return strlen($header);
    }
    
    /**
     * @param const $mode Sets the desired HTTP mode (GET, POST, PUT, DELETE)
     */
    protected function setHttpMode($mode)
    {
        if(in_array($mode, array(self::HTTP_GET, self::HTTP_POST, self::HTTP_PUT, self::HTTP_DELETE))) {
            $this->httpMode = $mode;
            curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, $this->httpMode);
        } else {
            throw new Exception\HarvestInvalidArgumentException(sprintf("Got unexpected HTTP mode %s.", $mode));
        }
    }
    
    protected function getHttpMode()
    {
        return $this->httpMode;
    }
    
    /**
     * @param const $mode Use either self::MODE_FAIL (fails if no success) or self::MODE_RETRY (retries on failure)
     */
    protected function setMode($mode = self::MODE_FAIL)
    {
        if($mode === self::MODE_FAIL || $mode === self::MODE_RETRY) {
            $this->mode = $mode;
        } else {
            throw new Exception\HarvestInvalidArgumentException(sprintf("Got unexpected mode %s, must be one of MODE_FAIL or MODE_RETRY.", $mode));
        }
    }

    /**
     * undocumented function
     *
     * @param string $data 
     * @return void
     * @author Bjorn
     */
    protected function setPostData($data = array())
    {
        if(!in_array($this->getHttpMode(), array(self::HTTP_POST, self::HTTP_PUT))) {
            $this->setHttpMode(self::HTTP_POST);
        }
        curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $data);
    }

    /**
     * Perform a Curl request prepared by `get()`, `post()`, etc.
     *
     * @param string $path
     * @return HttpResponse
     */
    protected function execute($path) {
        $parameters = (!empty($this->urlParameters)) ? '?'.http_build_query($this->urlParameters) : '';
        curl_setopt($this->curlHandle, CURLOPT_URL, "https://{$this->account}.harvestapp.com/" . $path . $parameters);
        
        $data = null;
        $code = null;
        $success = false;

        while (! $success) {
            $data = curl_exec($this->curlHandle);
            $code = curl_getinfo($this->curlHandle, CURLINFO_HTTP_CODE);

            if ($this->mode === HttpClient::MODE_RETRY && $code === "503") {
                $success = false;
                sleep($this->headers['Retry-After']);
            } else {
                $success = true;
            }
        }

        return new HttpResponse($this->curlHandle, $code, $data, $this->headers);
    }
    
    /**
     * Prepare and perform a HTTP GET request.
     *
     * @param string $path
     * @param bool|string $multi true, 'raw'
     * @return HttpResponse
     */
    public function get($path, $multi = true)
    {
        $this->clearHeaders();
        
        $response = $this->execute($path);
        $data = $response->get('data');

        if($response->isSuccess()) {
            if ($multi === true) {
                $data = $this->parseItems($data);
            } elseif ($multi === "raw") {
                $data = $data;
            } else {
                $data = $this->parseItem($data);
            }
        }

        $response->data = $data;

        return $response;
    }

    /**
     * Prepare and perform a HTTP POST request.
     *
     * @param string $path 
     * @param string $data 
     * @param bool|string $multi true, 'id', 'raw'
     * @return HttpResponse
     */
    public function post($path, $data = '', $multi = 'id')
    {
        $this->clearHeaders();
        $this->setPostData($data);
        $this->setHttpMode(self::HTTP_POST);
        
        $response = $this->execute($path);
        $responseData = $response->get('data');
        
        if($response->isSuccess()) {
            if ($multi === "id") {
                $responseData = $this->headers["Location"];
            } elseif ($multi === true) {
                $responseData = $this->parseItems($responseData);
            } elseif ($multi == "raw") {
                $responseData = $data;
            } else {
                $responseData = $this->parseItem($responseData);
            }
        }
        
        $response->data = $responseData;
        return $response;
    }

    /**
     * Prepare and perform a HTTP PUT request.
     *
     * @param string $path 
     * @param string $data 
     * @return HttpResponse
     */
    public function put($path, $data = '') {
        $this->clearHeaders();
        $this->setPostData($data);
        $this->setHttpMode(self::HTTP_PUT);
        
        return $this->execute($path);
    }

    /**
     * Prepare and perform a HTTP DELETE request.
     *
     * @param string $path 
     * @return HttpResponse
     */
    public function delete($path) {
        $this->clearHeaders();
        $this->setHttpMode(self::HTTP_DELETE);

        return $this->execute($path);
    }

    /**
     * parse XML list
     * @param  string $xml XML String
     * @return array
     */
    public function parseItems($xml)
    {
        $items = array();
        $xmlDoc = new \DOMDocument;
        $xmlDoc->loadXML($xml);

        foreach ($xmlDoc->documentElement->childNodes as $item) {
            $item = $this->parseNode($item);

            if (! is_null($item)) {
                $items[$item->id()] = $item;
            }
        }

        return $items;
    }

    /**
     * parse XML item
     * @param  string $xml XML String
     * @return mixed
     */
    public function parseItem($xml)
    {
        $xmlDoc = new \DOMDocument();
        $xmlDoc->loadXML($xml);
        return $this->parseNode($xmlDoc->documentElement);
    }

    /**
     * parse xml node
     * @param  DocumentElement $node document element
     * @return mixed
     */
    protected function parseNode($node)
    {
        $item = null;
        switch ($node->nodeName) {
            case "expense-category":
                $item = new Model\ExpenseCategory;
                break;
            case "client":
                $item = new Model\Client;
                break;
            case "contact":
                $item = new Model\Contact;
                break;
            case "company":
                $item = new Model\Company;
                break;
            case "add":
                $children = $node->childNodes;
                foreach ($children as $child) {
                    if ($child->nodeName === "day_entry") {
                        $node = $child;
                        break;
                    }
                }
            case "day_entry":
            case "day-entry":
                $item = new Model\DayEntry;
                break;
            case "expense":
                $item = new Model\Expense;
                break;
            case "invoice":
                $item = new Model\Invoice;
                break;
            case "invoice-item-category":
                $item = new Model\InvoiceItemCategory;
                break;
            case "invoice-message":
                $item = new Model\InvoiceMessage;
                break;
            case "payment":
                $item = new Model\Payment;
                break;
            case "project":
                $item = new Model\Project;
                break;
            case "task":
                $item = new Model\Task;
                break;
            case "user":
                $item = new Model\User;
                break;
            case "user-assignment":
                $item = new Model\UserAssignment;
                break;
            case "task-assignment":
                $item = new Model\TaskAssignment;
                break;
            case "daily":
                $item = new Model\DailyActivity;
                break;
            case "timer":
                $item = new Model\Timer;
                break;
            case "hash":
                $item = new Model\Throttle;
                break;
            case "#text":
                break;
            default:
                throw new Exception\HarvestException(sprintf('Got type %s, but there is no Model assigned to that.', $node->nodeName));
                break;
        }

        if (!is_null($item)) {
            $item->parseXml($node);
        }

        return $item;
    }
}
