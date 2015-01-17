<?php

namespace Harvest\Api;

abstract class AbstractApi
{
    protected $harvest;

    public function __construct(\Harvest\HarvestApi $harvest) {
        $this->harvest = $harvest;
    }

    protected function get($path, $multi) {
        return $this->harvest->getHttpClient()->get($path, $multi);
    }

    protected function post($path, $data) {
        return $this->harvest->getHttpClient()->post($path, $data);
    }

    protected function patch() {
        return "blaaaah!";
    }

    protected function put() {
        return "blaaaah!";
    }

    protected function delete() {
        return "blaaaah!";
    }

    protected function appendUpdatedSinceParam($updated_since = null)
    {
        if (is_null($updated_since)) {
            return "";
        } elseif ($updated_since instanceOf DateTime) {
            return '?updated_since=' . urlencode($updated_since->format("Y-m-d G:i"));
        } else {
            return '?updated_since=' . urlencode($updated_since);
        }
    }
}
