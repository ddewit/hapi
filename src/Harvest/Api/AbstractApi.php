<?php

namespace Harvest\Api;

abstract class AbstractApi
{
    /**
     * @var HarvestApi
     */
    protected $harvest;

    public function __construct(\Harvest\HarvestApi $harvest) {
        $this->harvest = $harvest;
    }

    /**
     * @return HttpResponse
     */
    protected function performGet($path, $multi) {
        return $this->harvest->getHttpClient()->get($path, $multi);
    }

    /**
     * @return HttpResponse
     */
    protected function performPost($path, $data) {
        return $this->harvest->getHttpClient()->post($path, $data);
    }

    /**
     * @return HttpResponse
     */
    protected function performPatch() {
        return $this->harvest->getHttpClient()->patch();
    }

    /**
     * @return HttpResponse
     */
    protected function performPut() {
        return $this->harvest->getHttpClient()->put();
    }

    /**
     * @return HttpResponse
     */
    protected function performDelete() {
        return $this->harvest->getHttpClient()->delete();
    }

    /**
     * @param DateTime $updated_since
     * @return string URL parameter
     */
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
