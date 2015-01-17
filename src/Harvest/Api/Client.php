<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class Client extends AbstractApi
{

    /**
     * get all clients
     *
     * <code>
     * $api = new HarvestApi();
     *
     * $result = $api->getClients();
     * if ($result->isSuccess()) {
     *     $clients = $result->data;
     * }
     * </code>
     *
     * @param  mixed  $updated_since DateTime
     * @return Result
     */
    public function all($updated_since = null)
    {
        $url = "clients" . $this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }

    /**
     * get a single client
     *
     * <code>
     * $client_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->getClient($client_id);
     * if ($result->isSuccess()) {
     *     $client = $result->data;
     * }
     * </code>
     *
     * @param  int    $client_id Client Identifier
     * @return Result
     */
    public function get($client_id)
    {
        $url = "clients/$client_id";
        return $this->performGet($url, false);
    }

    /**
     * create new client
     *
     * <code>
     * $client = new Client();
     * $client->set("name", "Company LLC");
     * $client->set("details", "Company Details");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createClient($client);
     * if ($result->isSuccess()) {
     *     // get id of created client
     *     $client_id = $result->data;
     * }
     * </code>
     *
     * @param  Client $client Client
     * @return Result
     */
    public function create(Model\Client $client)
    {
        $url = "clients";
        return $this->performPost($url, $client->toXml());
    }

    /**
     * update a client
     *
     * <code>
     * $client = new Client();
     * $client->set("id", 11111);
     * client->set("name", "Company LLC");
     * $client->set("details", "New Company Details");
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateClient($client);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  Client $client Client
     * @return Result
     */
    public function update(Model\Client $client)
    {
        $url = "clients/$client->id";
        return $this->performPut($url, $client->toXml());
    }

    /**
     * activate / deactivate a client
     *
     * <code>
     * $client_id = 11111;
     * $api = new HarvestApi();
     * $result = $api->toggleClient($client_id);
     * if ($result->isSuccess()) {
     *     // addtional logic
     * }
     * </code>
     *
     * @param $int client_id Client Identifier
     * @return Result
     */
    public function toggle($client_id)
    {
        $url = "clients/$client_id/toggle";
        return $this->performPut($url, "");
    }

    /**
     * delete a client
     *
     * <code>
     * $client_id = 11111;
     * $api = new HarvestApi();
     * $result = $api->deleteClient($client_id);
     * if ($result->isSuccess()) {
     *      // additional logic
     * }
     * </code>
     *
     * @param  int    $client_id Client Identifier
     * @return Result
     */
    public function delete($client_id)
    {
        $url = "clients/$client_id";
        return $this->performDelete($url);
    }
}
