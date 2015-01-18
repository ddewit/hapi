<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;

class Account extends AbstractApi
{

    public function whoAmI()
    {
        $url = "account/who_am_i";
        return $this->performGet($url, true);
    }
}
