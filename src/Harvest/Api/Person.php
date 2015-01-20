<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class Person extends AbstractApi
{
    
    public function all($updated_since = null)
    {
        $url = "people";
        $this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }

    public function get($user_id)
    {
        $url = "people/$user_id";
        return $this->performGet($url, false);
    }

    public function create(Model\User $user)
    {
        $url = "people";
        return $this->performPost($url, $user->toXml());
    }

    public function update(Model\User $user)
    {
        $url = "people/$user->id";
        return $this->performPut($url, $user->toXml());
    }
    
    public function toggle($user_id)
    {
        $url = "people/$user_id/toggle";
        return $this->performPut($url, '');
    }

    public function delete($user_id)
    {
        $url = "people/$user_id";
        return $this->performDelete($url);
    }
}