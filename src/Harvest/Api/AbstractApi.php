<?php

namespace Harvest\Api;

abstract class AbstractApi
{
    protected $harvest;

    public function __construct(\Harvest\HarvestApi $harvest) {
        $this->harvest = $harvest;
    }

    protected function performGet($path, $multi) {
        return $this->harvest->getHttpClient()->get($path, $multi);
    }

    protected function performPost($path, $data) {
        return $this->harvest->getHttpClient()->post($path, $data);
    }

    protected function performPatch() {
        return $this->harvest->getHttpClient()->patch();
    }

    protected function performPut() {
        return $this->harvest->getHttpClient()->put();
    }

    protected function performDelete() {
        return $this->harvest->getHttpClient()->delete();
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
