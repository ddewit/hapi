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
    protected function performPut($path, $data) {
        return $this->harvest->getHttpClient()->put($path, $data);
    }

    /**
     * @return HttpResponse
     */
    protected function performDelete($path) {
        return $this->harvest->getHttpClient()->delete($path);
    }

    /**
     * @param DateTime $updated_since
     * @return string URL parameter
     */
    public function appendUpdatedSinceParam($updated_since = null)
    {
        if (is_null($updated_since)) {
            return "";
        } elseif ($updated_since instanceof \DateTime) {
            return '?updated_since=' . urlencode($updated_since->format("Y-m-d G:i"));
        } else {
            return '?updated_since=' . urlencode($updated_since);
        }
    }
}
