<?php

namespace Harvest;

use Harvest\Model;
use Harvest\Model\Invoice;

class HarvestApi
{
    private $httpClient;

    public function api($name)
    {
        switch($name) {
            case 'project':
            case 'projects':
                $api = new Api\Project($this);
                break;

            case 'client':
            case 'clients':
                $api = new Api\Client($this);
                break;

            default:
                throw new \InvalidArgumentException(sprintf('Unknown API requested, got: %s', $name));
                break;
        }

        return $api;
    }

    public function authenticate($username = null, $password = null) {
        $this->getHttpClient()->authenticate($username, $password);
    }

    public function setAccount($account) {
        $this->getHttpClient()->setAccount($account);
    }

    public function getHttpClient() {
        if($this->httpClient === null) {
            $this->httpClient = new HttpClient\HttpClient;
        }

        return $this->httpClient;
    }
}
