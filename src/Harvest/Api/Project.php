<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class Project extends AbstractApi
{
    
    public function all($updated_since = null)
    {
        $url = "projects";
        $this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }

    public function getProjectsForClient($client_id)
    {
        $url = "projects?client=$client_id";
        return $this->performGet($url, true);
    }

    public function get($project_id)
    {
        $url = "projects/$project_id";
        return $this->performGet($url, false);
    }

    public function create(Model\Project $project)
    {
        $url = "projects";
        return $this->performPost($url, $project->toXml());
    }

    public function update(Model\Project $project)
    {
        $url = "projects/$project->id";
        return $this->performPut($url, $project->toXml());
    }

    public function toggle($project_id)
    {
        $url = "projects/$project_id/toggle";
        return $this->performPut($url, "");
    }

    public function delete($project_id)
    {
        $url = "projects/$project_id";
        return $this->performDelete($url);
    }
}
