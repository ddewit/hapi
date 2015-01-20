<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class Contact extends AbstractApi
{
    
    public function all($updated_since = null)
    {
        $url = "contacts";
        $this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }

    public function allContactsForClient($client_id)
    {
        $url = "clients/$client_id/contacts";
        return $this->performGet($url, true);
    }

    public function get($contact_id)
    {
        $url = "contacts/$contact_id";
        return $this->performGet($url, false);
    }

    public function create(Model\Contact $contact)
    {
        $url = "contacts";
        return $this->performPost($url, $contact->toXml());
    }

    public function update(Model\Contact $contact)
    {
        $url = "contacts/$contact->id";
        return $this->performPut($url, $contact->toXml());
    }

    public function delete($contact_id)
    {
        $url = "contacts/$contact_id";
        return $this->performDelete($url);
    }
}
