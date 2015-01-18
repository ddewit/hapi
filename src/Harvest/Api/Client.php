<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class Client extends AbstractApi
{

    public function all($updated_since = null)
    {
        $url = "clients";
        $this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }

    public function get($client_id)
    {
        $url = "clients/$client_id";
        return $this->performGet($url, false);
    }

    public function create(Model\Client $client)
    {
        $url = "clients";
        return $this->performPost($url, $client->toXml());
    }

    public function update(Model\Client $client)
    {
        $url = "clients/$client->id";
        return $this->performPut($url, $client->toXml());
    }

    public function toggle($client_id)
    {
        $url = "clients/$client_id/toggle";
        return $this->performPut($url, "");
    }

    public function delete($client_id)
    {
        $url = "clients/$client_id";
        return $this->performDelete($url);
    }
}
