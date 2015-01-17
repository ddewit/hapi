<?php

namespace Harvest\HttpClient;

use Harvest\Model;
use Harvest\Exception;

class HttpClient
{
    const MODE_RETRY = 'WAIT';
    const MODE_FAIL = 'FAIL';

    protected $mode = self::MODE_FAIL;
    protected $headers = array();

    private $username;
    private $password;
    private $account;

    private $curlHandle;
    private $postData = array();

    public function authenticate($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function setAccount($account)
    {
        $this->account = $account;
    }

    public function setHeaders($headers = array())
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    public function clearHeaders()
    {
        $this->headers = array(
            'User-Agent: PHP Wrapper Library for Harvest API',
            'Accept: application/xml',
            'Content-Type: application/xml',
            'Authorization: Basic ' . base64_encode($this->username . ":" . $this->password),
       );
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

    protected function setPostData($data = array())
    {
        $this->postData = $data;
    }

    protected function generateCurl($url)
    {
        $this->curlHandle = curl_init();
        curl_setopt($this->curlHandle, CURLOPT_URL, "https://{$this->account}.harvestapp.com/" . $url);
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curlHandle, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->curlHandle, CURLOPT_HEADERFUNCTION, array(&$this,'parseHeader'));

        if($this->postData) {
            curl_setopt($this->curlHandle, CURLOPT_POST, 1);
            curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $this->postData);
        }
    }

    protected function execute($url) {
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

        return new HttpResponse($code, $data, $this->headers);
    }

    public function get($url, $multi = true)
    {
        $this->clearHeaders();
        $this->generateCurl($url);

        $response = $this->execute($url);
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

    public function post($url, $data = true, $multi = "id")
    {
        $this->clearHeaders();
        $this->setPostData($data);
        $this->generateCurl($url);

        $response = $this->execute($url);
        $responseData = $response->get('data');

        if($response->isSuccess()) {
            if ($multi == "id") {
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

    public function patch() {
        return "blaaaah!";
    }

    public function put() {
        return "blaaaah!";
    }

    public function delete() {
        return "blaaaah!";
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
        $xmlDoc = $xmlDoc->loadXML($xml);

        foreach ($xmlDoc->documentElement->childNodes AS $item) {
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
            default:
            break;
        }

        if (!is_null($item)) {
            $item->parseXml($node);
        }

        return $item;
    }
}
