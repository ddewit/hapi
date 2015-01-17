<?php

namespace Harvest;

class HarvestApi
{
    /**
     * Class that handles all communication with Harvest
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Request a API instance
     *
     * @param string $name
     * @return AbstractApi
     * @throws InvalidArgumentException If requested API does not exist.
     */
    public function api($name)
    {
        if(class_exists("\\Harvest\\Api\\{$name}")) {
            $className = "\\Harvest\\Api\\{$name}";
            $api = new $className($this);
        } else {
            throw new \InvalidArgumentException(sprintf('Unknown API requested, got: %s. Is it in StudlyCaps?', $name));
        }

        return $api;
    }

    /**
     * Set authentication for all following requests
     *
     * @param string $username Emailaddress of the user
     * @param string $password Password of the user
     * @return void
     */
    public function authenticate($username = null, $password = null) {
        $this->getHttpClient()->authenticate($username, $password);
    }

    /**
     * Set the account for all following requests
     *
     * @param string $account
     * @return void
     */
    public function setAccount($account) {
        $this->getHttpClient()->setAccount($account);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient() {
        if($this->httpClient === null) {
            $this->httpClient = new HttpClient\HttpClient;
        }

        return $this->httpClient;
    }
}
